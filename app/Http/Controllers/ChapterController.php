<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function edit(Chapter $chapter)
    {
        $this->authorize('edit', $chapter);

        dd(func_get_args());
    }

    public function delete(Chapter $chapter)
    {
        $this->authorize('delete', $chapter);

        dd(func_get_args());
    }
}
