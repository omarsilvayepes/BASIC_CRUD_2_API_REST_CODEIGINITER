<?php 

function hashPassword($plaintText)
{
    return password_hash($plaintText,PASSWORD_BCRYPT);
}

function verifyPassword($plainText,$hash)
{
    return password_verify($plainText,$hash);
}

?>