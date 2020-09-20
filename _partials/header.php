---
description: ''
---
<nav class="navbar navbar-light navbar-top navbar-expand-md fixed-top">
    <div class="container-fluid">
        <?= partial('nav/logo'); ?>
        <!--        <div class="justify-content-end">-->
        <!--            -->
        <!--        </div>-->
        <button
                class="navbar-toggler border-0"
                type="button"
                data-toggle="collapse"
                data-target="#navbarMainHeader"
                aria-controls="navbarMainHeader"
                aria-expanded="false"
                aria-label="Toggle navigation"
        ><span class="navbar-toggler-icon"></span></button>

        <div class="justify-content-start collapse navbar-collapse" id="navbarMainHeader" style="width: 180px;">
            <div class="row smoova-header-search">
                <div class="col-sm-6 smoova-search">
                    <?= partial('localList::search'); ?>
                </div>
                <div class="col-sm-6 smoova-location-search">
                    <?= partial('localBox::searchbar'); ?>
                </div>
            </div>
            <?= partial('nav/main_menu', ['items' => $mainMenu->menuItems()]); ?>
        </div>
    </div>
</nav>
