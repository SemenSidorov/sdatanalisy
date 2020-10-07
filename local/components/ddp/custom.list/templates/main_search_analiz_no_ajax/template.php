<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<div class="welcome">
    <div class="welcome__inner">
        <div class="welcome__title">
            Сдать анализы в удобное время рядом с домом
        </div>
        <form action="/search/" class="welcome__search" method="get">
            <input name="q" value="" class="welcome__search-field" type="text" autocomplete="off" placeholder="Введите название исследования" />
            <input type="submit" class="welcome__search-btn" value="" />
        </form>
        <div class="welcome__note">
            Например, клинический анализ крови
        </div>
    </div>
</div>