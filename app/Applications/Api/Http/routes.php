<?php

Route::resource('notes', 'NotesController')->except([
    'create', 'edit'
]);
