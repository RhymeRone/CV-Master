<?php

namespace App\Constants;

class ValidationRules
{
    public const MAX_FILE_SIZE = 2048; // 2MB
    public const MAX_CV_SIZE = 5120;   // 5MB
    public const ALLOWED_CV_TYPES = ['pdf', 'doc', 'docx'];
    public const MAX_STRING_LENGTH = 255;
} 