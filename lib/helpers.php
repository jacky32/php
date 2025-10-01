<?php
function toSnakeCase($input)
{
  return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
}
