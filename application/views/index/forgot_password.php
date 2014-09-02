<h3>Forgot password</h3>
<form id="forgotpwd_form" action="" method="post">
    <div id="flash_msg"><?=@$flash_msg?></div>
    <table>
        <tr>
            <td  align="left">
                <label>Email ID: </label>
            </td>
            <td align="left">
                <input type="text" name="email" id="email" />
                <?=form_error('email') ?>
            </td>
        </tr>

        <tr>
            <td  colspan="2" align="center">
                <input type="submit" name="forgotpwd" id="forgotpwd" value="Submit">
            </td>
        </tr>
    </table>
</form>
