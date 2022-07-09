<?php

use App\Models\User;

function validateUser($id) {
    return User::where('id', $id)->first() ?? false;
}