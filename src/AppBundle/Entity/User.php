<?php
namespace AppBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email",
 *          column=@ORM\Column(
 *              name     = "email",
 *              type     = "string",
 *              length   = 255,
 *              nullable = true
 *          )
 *      ),
 *      @ORM\AttributeOverride(name="emailCanonical",
 *          column=@ORM\Column(
 *              name     = "emailCanonical",
 *              type     = "string",
 *              length   = 255,
 *              nullable = true
 *          )
 *      ),
 * })
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=true)
     * @ORM\GeneratedValue(strategy="AUTO") 
     */
    protected $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $nbpt;
    public function __construct()
    {
        parent::__construct();
        $this->nbpt= 0;
        // your own logic
       
    }
}