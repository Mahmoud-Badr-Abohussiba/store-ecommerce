<?php
function getCssFolder()
{
    return app()->getLocale()==='ar'?'css-rtl':'css';
}
