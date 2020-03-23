<?php
/**
 * Created by PhpStorm.
 * User: flore
 * Date: 02/10/2018
 * Time: 15:11
 */

namespace FMDD\SyliusCartBlamerPlugin\Listener;

use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Order\Model\OrderItemInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

final class AddToCartListener
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param ResourceControllerEvent $event
     */
    public function onSuccessfulAddToCart(ResourceControllerEvent $event)
    {
        if (!$event->getSubject() instanceof OrderItemInterface) {
            throw new \LogicException(
                sprintf('This listener operates only on order item, got "$s"', get_class($event->getSubject()))
            );
        }

        $newUrl = $this->router->generate('sylius_shop_homepage', []);

        $event->setResponse(new RedirectResponse($newUrl));
    }
}
