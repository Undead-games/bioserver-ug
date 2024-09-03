<?php

declare(strict_types=1);

namespace App\Application\Actions\Login\Handlers;

use App\Application\Actions\Login\ValueObjects\Password;
use App\Application\Actions\Login\ValueObjects\UserName;
use App\Domain\Login\LoginException;
use App\Domain\Login\LoginHandlerInterface;
use App\Domain\User\User;
use mysqli;

final class RegisterHandler implements LoginHandlerInterface
{
    public function __construct(
        private mysqli $mysql
    ) {
        
    }

    public function handle(UserName $username, Password $password): void
    {
        $userid = $username->value;
        $passwd = $password->value; 

        $stmnt = $this->mysql->prepare("insert into users (userid, passwd) values (?, ?)");
        $stmnt->bind_param("ss", $userid, $passwd);

        $res = $stmnt->execute();

        if (! $res) {
            throw new LoginException("Registration failed.");
        }
    }
}
