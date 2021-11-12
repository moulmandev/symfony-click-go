<?php

namespace App\Form;

use App\Entity\Shop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address', TextType::class, [
                "attr" => ["class" => "form-control border-end-0 border rounded-pill"],
                "row_attr" => ["class" => "input-group"],
                "label" => false,
            ])
        ;
    }

    /*
     *
     *   <form>
            <label for="adress">Entrez votre adresse pour trouver des magasins près de chez vous.</label>
            <div class="input-group">
                <input class="" type="text" value="" name="adress" id="adress">
                <span class="input-group-append">
                    <button class="btn btn-outline-secondary bg-white border-start-0 border rounded-pill ms-n3" type="sumbit">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
     *
     */


//    public function configureOptions(OptionsResolver $resolver): void
//    {
//        $resolver->setDefaults([
//            'data_class' => Shop::class,
//        ]);
//    }
}
