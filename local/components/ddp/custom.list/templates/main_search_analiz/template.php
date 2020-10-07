<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<div class="welcome" id="main_search_analyz">
    <div class="welcome__inner">
        <div class="welcome__title">
            Сдать анализы в удобное время рядом с домом
        </div>
        <form action="" class="welcome__search">
            <input value="" class="welcome__search-field" type="text" autocomplete="off" placeholder="Введите название исследования" v-model="question" />
            <input type="submit" class="welcome__search-btn" value="" />
            <div class="welcome__search-dropdown" v-if="items.length > 0">
                <main-search-analyz-item v-for="item in items" v-bind:item="item"></main-search-analyz-item>
            </div>
        </form>
        <div class="welcome__note">
            Например, клинический анализ крови
        </div>
    </div>
</div>