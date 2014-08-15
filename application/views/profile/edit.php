<h3>Edit Profile</h3>
<form id="edit_form" action="" method="post">
    <div id="flash_msg"><?=@$flash_arr['flash_msg']?></div>
    <table>
        <tr>
            <td  align="left">
                <label>Firstname: </label>
            </td>
            <td align="left">
                <input type="text" name="firstname" id="firstname" value="<?=$user_profile[0]->Firstname?>" />
                <?=form_error('firstname') ?>
            </td>
        </tr>
        <tr>
            <td  align="left">
                <label>Lastname: </label>
            </td>
            <td align="left">
                <input type="text" name="lastname" id="lastname" value="<?=$user_profile[0]->Lastname?>" />
                <?=form_error('lastname') ?>
            </td>
        </tr>
        <tr>
            <td  align="left">
                <label>Email: </label>
            </td>
            <td align="left">
                <input type="text" name="email" id="email" value="<?=$user_profile[0]->EmailId?>"  />
                <?=form_error('email') ?>
            </td>
        </tr>
        <tr>
            <td  align="left">
                <label>City: </label>
            </td>
            <td align="left">
                <input type="text" name="city" id="city" value="<?=$user_profile[0]->City?>"  />
                <?=form_error('city') ?>
            </td>
        </tr>
        <tr>
            <td  align="left">
                <label>State: </label>
            </td>
            <td align="left">
                <input type="text" name="state" id="state" value="<?=$user_profile[0]->State?>"  />
                <?=form_error('state') ?>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <input type="submit" name="login" id="login" value="Submit">
            </td>
        </tr>
    </table>
</form>
