<?php
/**
 * Loom
 * 
 * @copyright   Copyright (c) 2014 Warrick Bayman.
 * @author		Warrick Bayman <me@warrickbayman.co.za>
 * @license     MIT License http://opensource.org/licenses/MIT
 * 
 */

namespace Loom\Contracts;


use Loom\Loom;

interface ArithmeticContract
{
    public function add(Loom $loom);

    public function sub(Loom $loom);
}