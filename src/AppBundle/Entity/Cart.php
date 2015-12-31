<?php

namespace AppBundle\Entity;
use Sylius\Component\Cart\Model\Cart as BaseCart;
use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Cart extends BaseCart
{
}

