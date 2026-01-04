<?php

/*
 * Copyright (c) 2023
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this
 * software and associated documentation files (the "Software"), to deal in the Software
 * without restriction, including without limitation the rights to use, copy, modify, merge,
 *  publish, distribute, sublicense, and/or sell copies of the Software, and to permit
 *  persons to whom the Software is furnished to do so, subject to the following
 *  conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies
 * or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPIRES
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NON INFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS
 * BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN
 * ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
 * CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
declare(strict_types=1);

return [
    'button' => [
        'add_document' => 'Add Document',
        'close' => 'Close',
        'save' => 'Save',
        'quick_look' => 'Quick Look',
        'full_record' => 'Full Record'
    ],
    'title' => [
        'add_document_modal_title' => 'Add or Upload New Document',
        'quick_look_modal_title' => 'Quick Look'
    ],
    'field_label' => [
        'modal_add_document' => 'Attach PDF or Image File',
        'modal_save_uploaded' => 'Add File',
        'modal_add_loading' => 'Loading Preview',
        'modal_doc_title' => 'Document Title',
        'modal_bookmark_label' => 'Bookmark label'
    ],
    'pages' => [
        'main' => [
            'document_list_thumb' => 'Thumbnail',
            'document_list_name' => 'Document Name',
            'document_list_user' => 'By'
        ]
    ],
    'image_detail' => [
        'current_title' => 'Current Title',
        'original_title' => 'Original Filename',
        'current_filesize' => 'Current Filesize (in bytes)',
        'original_filesize' => 'Original Filesize (in bytes)',
        'uploaded_by' => 'Uploaded By',
        'dirty' => [
            'dirty_state' => 'Finished processing',
            'is_dirty' => 'Not Processed',
            'is_not_dirty' => 'Processed',
        ]
    ]
];
