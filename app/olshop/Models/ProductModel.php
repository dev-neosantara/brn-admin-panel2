<?php 
namespace Olshop\Models;
use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'olshop_product';
    protected $primaryKey = 'id';
    protected $allowedFields = ['pd_name', 'pd_price', 'onboarding', 'pd_weight', 'is_published', 'pd_cat_id'];
}