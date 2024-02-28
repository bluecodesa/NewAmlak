<?php

// app/Enums/OfficeStatus.php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OfficeStatus extends Enum
{
    const PENDING = 'pending';
    const APPROVED = 'approved';
    const REJECTED = 'rejected';
    // Add more status values as needed
}
