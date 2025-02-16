<?php

namespace App\Controller\Admin;

use App\Entity\Cepage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CepageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Cepage::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom du cépage'),
            // IdField::new('id'),
            // TextField::new('title'),
            // TextEditorField::new('description'),
        ];
    }
    
}
