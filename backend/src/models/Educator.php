<?php

namespace App\Models;

class Educator {
    public $id;
    public $name;
    public $area;
    public $personalDescription;
    public $email;
    public $location;
    public $profilePic;
    public $optionalPics;
    public $certifications;
    public $experience;
    public $oficialTitles;
    public $articles;
    public $communityMessages;

    public function __construct($data) {
        $this->id = $data['id'] ?? null;
        $this->name = $data['name'];
        $this->area = $data['area'];
        $this->personalDescription = $data['personalDescription'];
        $this->email = $data['email'];
        $this->location = $data['location'];
        $this->profilePic = $data['profilePic'];
        $this->optionalPics = $data['optionalPics'] ?? [];
        $this->certifications = $data['certifications'] ?? [];
        $this->experience = $data['experience'] ?? [];
        $this->oficialTitles = $data['oficialTitles'] ?? [];
        $this->articles = $data['articles'] ?? [];
        $this->communityMessages = $data['communityMessages'] ?? [];
    }
}