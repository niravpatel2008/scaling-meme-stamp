<h3>Sign in to continue</h3>
<form id="login_form" action="" method="post">
    <div id="flash_msg"><?=@$error_msg?></div>
    <table>
        <tr>
            <td  align="left">
                <label>Mobile number: </label>
            </td>
            <td align="left">
                <input type="text" name="mobile" id="mobile" />
                <?=form_error('mobile') ?>
            </td>
        </tr>
        <tr>
            <td  align="left">
                <label>Password: </label>
            </td>
            <td align="left">
                <input type="text" name="password" id="password" />
                <?=form_error('password') ?>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <input type="submit" name="login" id="login" value="Sign in">
            </td>
        </tr>
    </table>
</form>
