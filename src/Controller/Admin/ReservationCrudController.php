<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
    }


//    public function configureFields(string $pageName): iterable
//    {
//        return [
//            TextField::new('name'),
//            TextField::new('picture_url'),
//            MoneyField::new('price')->setCurrency('EUR'),
//            IntegerField::new('quantity'),
//            AssociationField::new('shop'),
//        ];
//    }
}
