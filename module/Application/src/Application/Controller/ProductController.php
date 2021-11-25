<?php
namespace Application\Controller;

use Application\Entity\Newproduct;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\JsonModel;
use Doctrine\ORM\EntityManager;
use General\Service\GeneralService;
use Laminas\Db\Sql\Ddl\Column\Datetime;
use Laminas\Validator\File\UploadFile;
use General\Service\UploadService;
use Doctrine\ORM\Query;
use Application\Entity\ProductComment;
use Laminas\InputFilter\InputFilter;

/**
 *
 * @author mac
 *        
 */
class ProductController extends AbstractActionController
{

    /**
     *
     * @var EntityManager
     */
    private $entityManager;

    /**
     *
     * @var GeneralService
     */
    private $generalService;

    /**
     *
     * @var UploadService
     */
    private $uploadService;

    /**
     */
    public function __construct()
    {
        
        // TODO - Insert your code here
    }
    
    public function onDispatch(MvcEvent $e)
    {
        $response = parent::onDispatch($e);
        $this->redirectPlugin()->redirectToLogout();
        $this->redirectPlugin()->roleRedirection();
        return $response;
    }

    public function createAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function createjsonAction()
    {
        $em = $this->entityManager;
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
        if ($request->isPost()) {
            $file = $request->getFiles()->toArray();
            $post = $request->getPost()->toArray();
            
            $validator = new UploadFile();
            if ($validator->isValid($file["image"])) {
                $imageEntity = $this->uploadService->upload($file["image"]);
                // /**
                // *
                // * @var Product $productEntity
                // */
                // $productEntity = $em->find(Product::class, $addProductSession->productid);
                try {
                    $newProduct = new Newproduct();
                    $newProduct->setName($post["pname"])
                        ->setPlaceId($post["placeid"])
                        ->setAddress($post["paddress"])
                        ->setProductUid(uniqid("pid"))
                        ->setLat($post["lat"])
                        ->setLon($post["lon"])
                        ->setImage($imageEntity)
                        ->setUser($this->identity())
                        ->setCreatedOn(new \Datetime());
                    
                    $em->persist($imageEntity);
                    $em->persist($newProduct);
                    
                    $response->setStatusCode(201);
                    $em->flush();
                } catch (\Throwable $th) {
                    $jsonModel->setVariables([
                        "data" => $th->getMessage()
                    ]);
                    $response->setStatusCode(400);
                }
                // $productEntity->addImage($imageEntity);
            } else {}
        }
        return $jsonModel;
    }

    public function viewAction()
    {
        $viewModel = new ViewModel();
        $em = $this->entityManager;
        $id = $this->params()->fromRoute("id", NULL);
        if ($id == NULL) {
            $this->redirect()->toRoute("newproduct");
        } else {
            $data = $em->getRepository(Newproduct::class)
                ->createQueryBuilder('n')
                ->select([
                "n",
                "u",
                "i"
            ])
                ->leftJoin("n.image", "i")
                ->leftJoin("n.user", "u")
                ->where("n.productUid = :id")
                ->setParameters([
                "id" => $id
            ])
                ->setMaxResults(20)
                ->getQuery()
                ->setHydrationMode(Query::HYDRATE_ARRAY)
                ->getArrayResult();
            
            $viewModel->setVariables([
                "data" => $data[0]
            ]);
        }
        return $viewModel;
    }

    public function getproductsAction()
    {
        $em = $this->entityManager;
        
        $jsonModel = new JsonModel();
        $data = $em->getRepository(Newproduct::class)
            ->createQueryBuilder("n")
            ->select([
            "n",
            "u",
            "i"
        ])
            ->leftJoin("n.image", "i")
            ->leftJoin("n.user", "u")
            ->orderBy("n.id", "DESC")
            ->setMaxResults(20)
            ->getQuery()
            ->setHydrationMode(Query::HYDRATE_ARRAY)
            ->getArrayResult();
        
        $jsonModel->setVariables([
            "data" => $data
        ]);
        return $jsonModel;
    }

    public function indexAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    public function commentAction()
    {
        $em = $this->entityManager;
        $jsonModel = new JsonModel();
        $id = $this->params()->fromRoute("id", NULL);
        $data = $em->getRepository(ProductComment::class)
            ->createQueryBuilder("p")
            ->select(["p", "u"])
            ->leftJoin("p.user", "u")
            ->where("p.product = :prod")
            ->setParameters([
            "prod" => $id
        ])
            ->getQuery()
            ->setHydrationMode(Query::HYDRATE_ARRAY)
            ->getArrayResult();
            
            $jsonModel->setVariables([
                "data"=>$data
            ]);
        return $jsonModel;
    }

    public function createcommentAction()
    {
        $jsonModel = new JsonModel();
        $request = $this->getRequest();
        $em = $this->entityManager;
        $response = $this->getResponse();
        if ($request->isPost()) {
            $post = $request->getPost();
            $newComment = new ProductComment();
            
            $inputFilter = new InputFilter();
            
            $inputFilter->add(array(
                'name' => 'comment',
                'required' => true,
                'allow_empty' => false,
                'filters' => array(
                    array(
                        'name' => 'StripTags'
                    ),
                    array(
                        'name' => 'StringTrim'
                    )
                ),
                'validators' => array(
                    array(
                        'name' => 'NotEmpty',
                        'options' => array(
                            'messages' => array(
                                'isEmpty' => 'Comment is required'
                            )
                        )
                    )
                )
            ));
            $inputFilter->setData($post);
            if ($inputFilter->isValid()) {
                try {
                    
                    $user = $this->identity();
                    $data = $inputFilter->getValues();
                    $newComment->setComment($data["comment"])
                        ->setCreatedOn(new \DateTime())
                        ->setUser($user)
                        ->setProduct($em->find(Newproduct::class, $post["product"]));
                    
                    $em->persist($newComment);
                    
                    $em->flush();
                    
                    // $fullLink = $this->url()->fromRoute('user-register', array(
                    // 'action' => 'confirm-email',
                    // 'id' => $user->getRegistrationToken()
                    // ), array(
                    // 'force_canonical' => true
                    // ));
                    
                    // $logo = $this->url()->fromRoute('home', array(), array(
                    // 'force_canonical' => true
                    // )) . "img/logo.png";
                    
                    // $mailer = $this->mail;
                    
                    $var = [
                        "title" => "Comment Made",
                        "message" => $data["comment"]
                    ];
                    
                    $template['template'] = "application-pulsating-button";
                    $template['var'] = $var;
                    
                    $messagePointer['to'] = $user->getEmail();
                    $messagePointer['fromName'] = "TRADER";
                    $messagePointer['subject'] = "TRADER: Comment made on product";
                    $this->generalService->sendMails($messagePointer, $template);
                    
                    $response->setStatusCode(201);
                } catch (\Exception $e) {
                    $jsonModel->setVariables([
                        "data" => $e->getMessage()
                    ]);
                }
            }
        }
        return $jsonModel;
    }

    /**
     *
     * @return the $entityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     *
     * @return the $generalService
     */
    public function getGeneralService()
    {
        return $this->generalService;
    }

    /**
     *
     * @param \Doctrine\ORM\EntityManager $entityManager            
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     *
     * @param \General\Service\GeneralService $generalService            
     */
    public function setGeneralService($generalService)
    {
        $this->generalService = $generalService;
        return $this;
    }

    /**
     *
     * @return the $uploadService
     */
    public function getUploadService()
    {
        return $this->uploadService;
    }

    /**
     *
     * @param \General\Service\UploadService $uploadService            
     */
    public function setUploadService($uploadService)
    {
        $this->uploadService = $uploadService;
        return $this;
    }
}
