<?php


namespace App\DAO;


use phpDocumentor\Reflection\Types\Array_;

class Form
{
    private $formCode = '';

    /**
     * Génére le formulaire html
     * @return string
     */
    public function createPost()
    {
        return $this->formCode;
    }

    /**
     * @param array $form
     * @param array $champs
     * @return bool
     */
    public static function validate( array $form, array $champs)
    {
        foreach ($champs as $champ) {
            if (!isset($form[$champ]) || empty($form[$champ])){
                return false;
            }
        }
        return true;
    }

    /**
     * @param array $attributs
     * @return string
     */

    public function ajoutAttributs(array $attributs):string
    {
        $str = '';

        return $str;
    }
}