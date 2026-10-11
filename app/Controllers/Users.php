<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Users extends BaseController
{
    private function handleAvatarUpload(): ?string
    {
        $file = $this->request->getFile('avatar');

        if ($file === null || !$file->isValid() || $file->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if ($file->getError() !== UPLOAD_ERR_OK) {
            throw new \RuntimeException('The uploaded avatar could not be processed.');
        }

        $allowedMimeTypes = ['image/jpeg', 'image/png'];
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, $allowedMimeTypes, true)) {
            throw new \RuntimeException('Avatar must be a JPG or PNG file.');
        }

        $size = $file->getSize();
        if ($size === null || $size > 2 * 1024 * 1024) {
            throw new \RuntimeException('Avatar must be 2MB or smaller.');
        }

        $extension = strtolower(pathinfo($file->getName(), PATHINFO_EXTENSION));
        if (!in_array($extension, ['jpg', 'jpeg', 'png'], true)) {
            $extension = $mimeType === 'image/png' ? 'png' : 'jpg';
        }

        $uploadDir = FCPATH . 'uploads';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $filename = 'avatar_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $extension;
        $destination = $uploadDir . DIRECTORY_SEPARATOR . $filename;

        $imageData = file_get_contents($file->getTempName());
        if ($imageData === false) {
            throw new \RuntimeException('The avatar file could not be read.');
        }

        $source = imagecreatefromstring($imageData);
        if ($source === false) {
            throw new \RuntimeException('The avatar file is not a valid JPG or PNG image.');
        }

        $width = imagesx($source);
        $height = imagesy($source);
        $maxDimension = 240;
        $scale = min(1, $maxDimension / max($width, $height));
        $newWidth = max(1, (int) round($width * $scale));
        $newHeight = max(1, (int) round($height * $scale));
        $resized = imagecreatetruecolor($newWidth, $newHeight);

        if ($extension === 'png') {
            imagealphablending($resized, false);
            imagesavealpha($resized, true);
            $transparent = imagecolorallocatealpha($resized, 255, 255, 255, 127);
            imagefilledrectangle($resized, 0, 0, $newWidth, $newHeight, $transparent);
        }

        imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        if ($extension === 'png') {
            imagepng($resized, $destination, 9);
        } else {
            imagejpeg($resized, $destination, 85);
        }

        imagedestroy($source);
        imagedestroy($resized);

        return $filename;
    }

    public function index()
    {
        $userModel = new UserModel();

        $data['users'] = $userModel->findAll();

        return view('users', $data);
    }

    public function new()
    {
        return view('user_form', [
            'user' => [],
            'formAction' => base_url('users/create'),
            'heading' => 'New User',
            'isEdit' => false,
        ]);
    }

    public function edit($id)
    {
        $user = (new UserModel())->find($id);
        if ($user === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return view('user_form', [
            'user' => $user,
            'formAction' => base_url("users/update/{$id}"),
            'heading' => 'Edit User',
            'isEdit' => true,
        ]);
    }

    public function create()
    {
        if (! $this->validate([
            'username' => 'required|min_length[3]',
            'password' => 'required|min_length[8]',
        ])) {
            return redirect()->back()->withInput()->with('error', 'Please fix the highlighted user fields.');
        }

        $avatar = null;
        try {
            $avatar = $this->handleAvatarUpload();
        } catch (\RuntimeException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        if ($avatar !== null) {
            $data['avatar'] = $avatar;
        }

        (new UserModel())->insert($data);

        return redirect()->to('/users');
    }

    public function update($id)
    {
        $model = new UserModel();
        if ($model->find($id) === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        if (! $this->validate(['username' => 'required|min_length[3]'])) {
            return redirect()->back()->withInput()->with('error', 'Please enter a valid username.');
        }

        $data = ['username' => $this->request->getPost('username')];
        $password = $this->request->getPost('password');
        if (is_string($password) && $password !== '') {
            if (strlen($password) < 8) {
                return redirect()->back()->withInput()->with('error', 'Password must be at least 8 characters.');
            }

            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        try {
            $uploadedAvatar = $this->handleAvatarUpload();
            if ($uploadedAvatar !== null) {
                $data['avatar'] = $uploadedAvatar;
            }
        } catch (\RuntimeException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        $model->update($id, $data);

        return redirect()->to('/users');
    }
}