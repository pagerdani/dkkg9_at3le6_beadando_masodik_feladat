<?php

Class Menu {
    private static function getVisitorRoleId()
    {
        $dbh = get_db_connection();
        $stmt = $dbh->prepare('SELECT id FROM szerepkorok WHERE kod = "latogato"');
        $stmt->execute([]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data["id"];
    }

    private static $menu = null;

    public static function getMenuStruct()
    {
        if (self::$menu != null) {
            return self::$menu;
        }

        $dbh = get_db_connection();
        $stmt = $dbh->prepare('SELECT id, parent_id, kod, nev FROM menu ORDER BY sorrend');
        $stmt->execute([]);
        $menuData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt = $dbh->prepare('SELECT menu_id, szerepkor_id FROM menu_szerepkorok');
        $stmt->execute([]);
        $menuRoleData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [];

        foreach ($menuData as $item) {
            $roleIds = [];

            foreach ($menuRoleData as $roleItem) {
                if ($roleItem['menu_id'] == $item['id']) {
                    $roleIds[] = $roleItem['szerepkor_id'];
                }
            }

            $parentCode = "";

            $parentMenuItem = self::getMenuDataById($menuData, $item['parent_id']);

            if ($parentMenuItem != null) {
                $parentCode = $parentMenuItem['kod'];
            }

            $result[$item['kod']] = [
                $item['nev'],
                $parentCode,
                $roleIds
            ];
        }

        self::$menu = $result;

        return self::$menu;
    }

    private static function getMenuDataById($menuData, $id)
    {
        foreach ($menuData as $item) {
            if ($item['id'] == $id) {
                return $item;
            }
        }

        return null;
    }

    public static function getMenu($sItems) {
        $visitorRoleId = self::getVisitorRoleId();
        self::getMenuStruct();

        $submenu = "";
        
        $menu = "<ul id='mainmenu'>";
        foreach(self::getMenuStruct() as $menuindex => $menuitem)
        {
            if (bejelentkezve()) {
                $mutat = in_array(felhasznalo_szerepkor_id(), $menuitem[2]);
            } else {
                $mutat = in_array($visitorRoleId, $menuitem[2]);
            }

            if ($mutat)
            {
                if($menuitem[1] == "")
                { $menu.= "<li id='menu-".$menuindex."'><a href='".SITE_ROOT.$menuindex."' ".($menuindex==$sItems[0]? "class='selected'":"").">".$menuitem[0]."</a></li>"; }
                else if($menuitem[1] == $sItems[0])
                { $submenu .= "<li id='menu-".$menuindex."'><a href='".SITE_ROOT.$sItems[0]."/".$menuindex."' ".($menuindex==$sItems[1]? "class='selected'":"").">".$menuitem[0]."</a></li>"; }
            }
        }
        $menu.="</ul>";
        
        if($submenu != "")
        {
            $submenu = "<ul id='submenu'>".$submenu."</ul>";
        }

        
        return $menu.$submenu;;
    }
}
?>