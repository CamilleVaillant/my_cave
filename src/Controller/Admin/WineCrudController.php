<?php

namespace App\Controller\Admin;

use App\Entity\Wine;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;

class WineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Wine::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom du vin'),
            IntegerField::new('year', 'Année'),
            TextEditorField::new('body', 'Description'),
            AssociationField::new('region', 'Région')->hideOnForm(), // Affichage de la région dans l'index
            AssociationField::new('cepages', 'Cépages')->hideOnForm(), // Affichage des cépages dans l'index
            ImageField::new('imageName', 'Image du vin')->setBasePath('/uploads/images')->setUploadDir('public/uploads/images')->setRequired(false),
            TextField::new('updatedAt', 'Mis à jour le')->onlyOnDetail(),
        ];
    }

    public function configureListFields(): iterable
    {
        return [
            TextField::new('name', 'Nom du vin'),
            IntegerField::new('year', 'Année'),
            TextEditorField::new('body', 'Description')->onlyOnIndex(),
            AssociationField::new('region', 'Région')
                ->formatValue(function ($value) {
                    return $value ? $value->getName() : 'Aucune région'; // Affichage du nom de la région
                })
                ->onlyOnIndex(),
            AssociationField::new('cepages', 'Cépages')
                ->setFormTypeOptions([
                    'by_reference'=>false,
                    'multiple'=>true,
                    'choise_label'=>'name',
                ])
                ->formatValue(function ($value,$entity) {
                    // Vérifie s'il y a des cépages, puis les formate sous forme de chaîne de texte séparée par des virgules
                    return implode(', ', $entity->getGrapes()->map(fn($cepage) => $cepage->getName())->toArray());
                })
                ->onlyOnIndex(),
            ImageField::new('imageName', 'Image du vin')
                ->setBasePath('/uploads/images')
                ->setUploadDir('public/uploads/images')
                ->onlyOnIndex(),
        ];
    }
}
