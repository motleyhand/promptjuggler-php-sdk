<?php

namespace PromptJuggler\Client\Models;

use Microsoft\Kiota\Abstractions\Enum;

class HttpCall_method extends Enum {
    public const G_E_T = "GET";
    public const P_O_S_T = "POST";
    public const P_U_T = "PUT";
    public const P_A_T_C_H = "PATCH";
    public const D_E_L_E_T_E = "DELETE";
}
