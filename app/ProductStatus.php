<?php

namespace App;

enum ProductStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
}
