<?php
namespace Shop\Form\Fieldset;

use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Form\Fieldset;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Shop\Entity\Category;
use Laminas\Filter\File\RenameUpload;

/**
 *
 * @author otaba
 *        
 */
class ProductCategoryFieldset extends Fieldset implements InputFilterProviderInterface
{
    /**
     *
     * @var string
     */
    private $labelClassAttributes;
    
    /**
     *
     * @var string
     */
    private $classAttributes;
    
    /**
     * 
     * @var EntityManager
     */
    private $entityManager;

    public function init(){
        $this->labelClassAttributes = "col-md-3 col-form-label text-md-right";
        $this->classAttribute = "form-control";
        
        $hydrator = new DoctrineObject($this->entityManager);
        $this->setObject(new Category())->setHydrator($hydrator);
        
        $this->add(array(
            "name"=>"category",
            "type"=>"text",
            "options"=>array(
                "label"=>"Category Name",
                "label_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>$this->classAttribute,
                "id"=>"category",
                "required"=>"required",
                "data-parsley-required" => "true",
                "ref"=>"category",
                "placeholder"=>"Men"
            )
        ));
        
        $this->add(array(
            "name"=>"image",
            "type"=>"file",
            "options"=>array(
                "label"=>"Category Banner Image",
                "label_attributes"=>array(
                    "class"=>$this->labelClassAttributes
                )
            ),
            "attributes"=>array(
                "class"=>$this->classAttribute,
                "id"=>"image",
                "required"=>"required",
                "data-parsley-required" => "true",
                "ref"=>"image"
            )
        ));
    }

    /**
     * (non-PHPdoc)
     *
     * @see \Laminas\InputFilter\InputFilterProviderInterface::getInputFilterSpecification()
     *
     */
    public function getInputFilterSpecification()
    {
        
        return array(
            "image"=>array(
                "required"=>true,
                "allow_empty"=>false,
//                 "filters"=>array(
//                     array(
//                         'name' => "Laminas\Filter\File\RenameUpload",
//                         "options"=>array(
//                             "target"=>realpath("./data/uploads/"),
//                             "randomize"=>true,
//                             "use_upload_extension"=>true
//                         ),
                        
//                     ),
//                 )
            ),
        );
    }
    /**
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param field_type $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

}

