<section class="three">
    <div class="container">

        <header>
            <h2>Change password</h2>
        </header>

        <form id="change_pwd_form" action="" method="post">
            <div id="flash_msg"><?=@$flash_msg?></div>
            <table>
                <tr>
                    <td  align="left">
                        <label>Old password: </label>
                    </td>
                    <td align="left">
                        <input type="text" name="old_password" id="old_password" value="<?=set_value('old_password')?>" />
                        <?=form_error('old_password') ?>
                    </td>
                </tr>

                <tr>
                    <td  align="left">
                        <label>New password: </label>
                    </td>
                    <td align="left">
                        <input type="text" name="new_password" id="new_password" value="" />
                        <?=form_error('new_password') ?>
                    </td>
                </tr>

                <tr>
                    <td  align="left">
                        <label>Confirm password: </label>
                    </td>
                    <td align="left">
                        <input type="text" name="confirm_password" id="confirm_password" value="" />
                        <?=form_error('confirm_password') ?>
                    </td>
                </tr>

                <tr>
                    <td  colspan="2" align="center">
                        <input type="submit" name="change_pwd" id="change_pwd" value="Submit">
                    </td>
                </tr>

            </table>
        </form>


    </div>
</section>
