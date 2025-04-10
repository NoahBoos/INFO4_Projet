<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use App\Entity\Editor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bookTitle')
            ->add('bookSummary')
            ->add('bookISBN')
            ->add('bookEditor', EntityType::class, [
                'class' => Editor::class,
                'choice_label' => 'editor_name',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'category_name',
            ])
            ->add('book_author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'author_name',
            ])
            ->add('book_cover', FileType::class, [
                'label' => 'Couverture du livre',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => ['image/jpeg', 'image/png'],
                        'mimeTypesMessage' => 'Sélectionnez un fichier JPEG ou PNG dont le poids est inférieur à 1024 ko.'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
