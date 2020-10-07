<?php

/**
 * Class Favorites
 * Работа с избранным
 */
class Favorites
{
    /**
     * Метод возвращает ID избранных клиник
     * @return array
     */
    public function getFavoriteClinics()
    {
        if (!isset($_SESSION['favorites'])) $_SESSION['favorites'] = array();
        return $_SESSION['favorites'];
    }

    /**
     * Метод добавляем клинику с заданным ID в избанное
     * @param int $id_clinic
     * @return bool
     */
    public function addFavoriteClinic($id_clinic = 0)
    {
        if ((int)$id_clinic) {
            if (!isset($_SESSION['favorites'])) $_SESSION['favorites'] = array();
            if (count($_SESSION['favorites']) < FAVORITES_MAX_COUNT) {
                $_SESSION['favorites'][] = (int)$id_clinic;
                return true;
            }
        }
        return false;
    }

    /**
     * Метод удаляет клинику с заданным ID из избранного
     * @param int $id_clinic
     * @return bool
     */
    public function delFavoriteClinic($id_clinic = 0)
    {
        if ((int)$id_clinic) {
            if (!isset($_SESSION['favorites'])) $_SESSION['favorites'] = array();
            $item = array_search((int)$id_clinic, $_SESSION['favorites']);
            if ($item !== false) {
                unset($_SESSION['favorites'][$item]);
                return true;
            }
        }
        return false;
    }

    /**
     * Метод сохраняет избранное в куки и пишет из кук в сесию если в ней пусто
     * @return bool
     */
    public function cookiesFavorite()
    {
        if (isset($_SESSION['favorites'])) {
            setcookie('favorites', $_SESSION['favorites'], time()+60*60*24*30, '/');
        } elseif($_COOKIE['favorites']) {
            $_SESSION['favorites'] = $_COOKIE['favorites'];
        }
        return true;
    }
}