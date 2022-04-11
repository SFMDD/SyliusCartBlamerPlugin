<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace FMDD\SyliusCartBlamerPlugin\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Sylius\Bundle\UserBundle\Event\UserEvent;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ShopUserInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use Sylius\Component\Order\Context\CartNotFoundException;
use Sylius\Component\Resource\Exception\UnexpectedTypeException;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * @author Michał Marcinkowski <michal.marcinkowski@lakion.com>
 */
final class CartBlamerListener
{
    /**
     * @var EntityManagerInterface
     */
    private $cartManager;

    /**
     * @var CartContextInterface
     */
    private $cartContext;

    /**
     * @var CartContextInterface
     */
    private $sessionCartContext;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * @param FlashBagInterface         $flashBag
     * @param EntityManagerInterface    $cartManager
     * @param CartContextInterface      $cartContext
     * @param CartContextInterface      $sessionCartContext
     */
    public function __construct(
        FlashBagInterface $flashBag,
        EntityManagerInterface $cartManager,
        CartContextInterface $cartContext,
        CartContextInterface $sessionCartContext
    ) {
        $this->flashBag        = $flashBag;
        $this->cartManager        = $cartManager;
        $this->cartContext        = $cartContext;
        $this->sessionCartContext = $sessionCartContext;
    }

    /**
     * @param UserEvent $userEvent
     */
    public function onImplicitLogin(UserEvent $userEvent): void
    {
        $user = $userEvent->getUser();
        if (!$user instanceof ShopUserInterface) {
            return;
        }

        $this->blame($user);
    }

    /**
     * @param InteractiveLoginEvent $interactiveLoginEvent
     */
    public function onInteractiveLogin(InteractiveLoginEvent $interactiveLoginEvent): void
    {
        $user = $interactiveLoginEvent->getAuthenticationToken()->getUser();
        if (!$user instanceof ShopUserInterface) {
            return;
        }

        $this->blame($user);
    }

    /**
     * @param ShopUserInterface $user
     */
    private function blame(ShopUserInterface $user): void
    {
        $cart = $this->getCart();
        if (null === $cart) {
            return;
        }

        try {
            $sessionCart = $this->sessionCartContext->getCart();
        } catch (CartNotFoundException $e) {
            $sessionCart = null;
        }
        if ($sessionCart !== null && $sessionCart->getId() !== $cart->getId()) {
            foreach ($sessionCart->getItems() as $item) {
                $cart->addItem($item);
            }
            $this->flashBag->add('info', 'fmdd_sylius_cart_blamer_plugin.cart_merge');
            $this->cartManager->remove($sessionCart);
            $this->cartManager->persist($sessionCart);
        } else {
            $cart->setCustomer($user->getCustomer());
        }
        $this->cartManager->persist($cart);
        $this->cartManager->flush();
    }

    /**
     * @return OrderInterface|null
     *
     * @throws UnexpectedTypeException
     */
    private function getCart(): ?OrderInterface
    {
        try {
            $cart = $this->cartContext->getCart();
        } catch (CartNotFoundException $exception) {
            return null;
        }

        if (!$cart instanceof OrderInterface) {
            throw new UnexpectedTypeException($cart, OrderInterface::class);
        }

        return $cart;
    }
}
