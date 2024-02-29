<?php

namespace Igniter\Orange\Exceptions;

use Illuminate\Http\Request;

class ReportableException extends \Exception
{
    public function render(Request $request)
    {
        if (config('app.debug', false)) {
            $response = $this->getPrevious()->getTrace();
            $response['message'] = sprintf('"%s" on line %s of %s',
                $this->getPrevious()->getMessage(),
                $this->getPrevious()->getLine(),
                $this->getPrevious()->getFile()
            );
        } else {
            $response['message'] = $this->getPrevious()->getMessage();
        }

        return response([
            'X_IGNITER_FLASH_MESSAGES' => [$response],
        ], 200);
    }
}