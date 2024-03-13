<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    //

    // public function showHierarchy()
    // {
    //     $rootPeople = Person::whereNull('parent_id')->get();

    //     echo "<ul>";
    //     foreach ($rootPeople as $person) {
    //         echo "<li>" . $person->name;
    //         $this->displayChildren($person);
    //         echo "</li>";
    //     }
    //     echo "</ul>";
    // }

    public function showHierarchy()
    {
        $rootPeople = Person::with('children')->whereNull('parent_id')->get();

    return view('hierarchical_data', ['rootPeople' => $rootPeople]);

        // $rootPeople = Person::whereNull('parent_id')->get();

        // return view('hierarchical_data', ['rootPeople' => $rootPeople]);
    }

    private function displayChildren($person)
    {
        $children = $person->children;
        if ($children->isNotEmpty()) {
            echo "<ul>";
            foreach ($children as $child) {
                echo "<li>" . $child->name;
                $this->displayChildren($child);
                echo "</li>";
            }
            echo "</ul>";
        }
    }
}
