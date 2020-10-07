<?php
    $arResult["ITEMS"] = Services::getSectionsToRegion();
    usort($arResult["ITEMS"], "my_array_sort");
    $arResult["ITEMS"] = array_slice($arResult["ITEMS"], 0, 5);
