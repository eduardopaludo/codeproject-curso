<?php
/**
 * Created by PhpStorm.
 * User: eduar
 * Date: 5/31/2016
 * Time: 2:04 AM
 */

namespace CodeProject\Validators;


use Prettus\Validator\LaravelValidator;

class ProjectNoteValidator extends LaravelValidator
{
    protected $rules = [
        'project_id' => 'required|integer',
        'title' => 'required',
        'name' => 'required',
    ];
}