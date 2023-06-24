<?php

declare(strict_types=1);

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace SocialApp\Apps\Demo\Webapp\BookStore\Form;

use SocialApp\Demo\BookCategory\Application\Query\FindBookCategoriesQuery;
use SocialApp\Demo\BookCategory\Domain\Dto\BookCategoryDto;
use SocialApp\Demo\BookCategory\Domain\Model\BookCategory;
use SocialApp\Demo\BookStore\Domain\Dto\BookDto;
use SocialApp\Shared\Application\Query\QueryBusInterface;

use function Lambdish\Phunctional\map;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BookType extends AbstractType
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('author')
            ->add('content')
            ->add('price', NumberType::class)
            ->add('category', ChoiceType::class, [
                'label' => 'Category',
                'choices' => $this->categories(),
                'choice_label' => function (?BookCategoryDto $category) {
                    return $category?->name;
                },
                'choice_value' => function (?BookCategoryDto $category) {
                    return $category?->id;
                },
            ])
            ->add('categories', ChoiceType::class, [
                'choices' => $this->categories(),
                'required' => false,
                'multiple' => true,
                'choice_label' => function (BookCategoryDto $category) {
                    return $category->name;
                },
                'choice_value' => function (BookCategoryDto $category) {
                    return $category->id;
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BookDto::class,
        ]);
    }

    /** @return BookCategoryDto[] */
    public function categories(): array
    {
        $categories = $this->queryBus->ask(new FindBookCategoriesQuery());

        return map(fn (BookCategory $category) => BookCategoryDto::fromModel($category), $categories);
    }
}
