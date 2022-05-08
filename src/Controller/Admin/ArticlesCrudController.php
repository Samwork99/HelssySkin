<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;




class ArticlesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Articles::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            BooleanField::new('published'),
            TextField::new('header'),
            ImageField::new('image')->setBasePath('images/articles_img')
            ->setUploadDir('public/images/articles_img'),
            TextEditorField::new('content'),
            DateTimeField::new('created_at')->hideOnForm(),
            DateTimeField::new('updated_at')->hideOnForm(),
        ];
    }
   
    // public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    // {
    //     if (!$entityInstance instanceof articles) return;

    //     $entityInstance->setCreated_at(new \DateTimeImmutable);

    //     parent::persistEntity($em, $entityInstance);
    // }
}
