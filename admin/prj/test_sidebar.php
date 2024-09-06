<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Menu</title>
    <style>
        li.sidebar_li {
            position: relative;
            display: block;
            padding: 10px;
        }

        .submenu_damares {
            display: none;
            position: relative;
            padding-left: 0;
            margin-top: 10px;
            clear: both;
            width: 100%;
            box-sizing: border-box;
        }

        .submenu_damares.active {
            display: block;
        }

        .submenu_damares li {
            padding-left: 20px;
        }

        .toggle-submenu {
            cursor: pointer;
            display: inline-block;
            margin-left: 5px;
            position: relative;
        }
    </style>
</head>
<body>

<ul>
    <li class="sidebar_li">
        <a href="#">Parent Item</a>
        <span class="toggle-submenu">+</span>
        <ul class="submenu_damares">
            <li><a href="#">Child Item 1</a></li>
            <li><a href="#">Child Item 2</a></li>
        </ul>
    </li>
</ul>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.toggle-submenu').on('click', function(e) {
            e.preventDefault();
            var $submenu = $(this).closest('li').find('.submenu_damares').first();
            if ($submenu.hasClass('active')) {
                $submenu.removeClass('active').slideUp();
                $(this).text('+');
            } else {
                $submenu.addClass('active').slideDown();
                $(this).text('-');
            }
        });
    });
</script>

</body>
</html>
