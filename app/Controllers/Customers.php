<?php
namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Customers extends BaseController
{
    public function index()
    {
        $customerModel = new CustomerModel();

        $data['customers'] = $customerModel->findAll();

        return view('customers', $data); 
    }

    public function new()
    {
        return view('customer_form', [
            'customer' => [],
            'formAction' => base_url('customers/create'),
            'heading' => 'New Customer',
        ]);
    }

    public function edit($id)
    {
        $customer = (new CustomerModel())->find($id);
        if ($customer === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('customer_form', [
            'customer' => $customer,
            'formAction' => base_url("customers/update/{$id}"),
            'heading' => 'Edit Customer',
        ]);
    }

    public function create()
    {
        $data = $this->request->getPost(['full_name', 'email', 'phone']);
        if (! $this->validate([
            'full_name' => 'required|min_length[2]',
            'email' => 'required|valid_email',
            'phone' => 'permit_empty',
        ])) {
            return redirect()->back()->withInput();
        }

        (new CustomerModel())->insert($data);

        return redirect()->to('/customers');
    }

    public function update($id)
    {
        $model = new CustomerModel();
        if ($model->find($id) === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $data = $this->request->getPost(['full_name', 'email', 'phone']);
        if (! $this->validate([
            'full_name' => 'required|min_length[2]',
            'email' => 'required|valid_email',
            'phone' => 'permit_empty',
        ])) {
            return redirect()->back()->withInput();
        }

        $model->update($id, $data);

        return redirect()->to('/customers');
    }
}