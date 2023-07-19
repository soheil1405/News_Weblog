<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected $uniqetitle = " این بخاطر تست عدم تکرار ی بودن عنوان خبر است ";


}
