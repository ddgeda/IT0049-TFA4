<?php
namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    public function index()
    {
        $customerModel = new CustomerModel();
        
        // Fetch records from the database instead of a static array
        $data['customers'] = $customerModel->findAll();

        return view('customers_view', $data); // Adjust view name to match your TFA1 view
    }
}