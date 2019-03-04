/**
 * @license CC BY-NC-SA 4.0
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/deed.ja
 * @copyright CodeCamp https://codecamp.jp
 */

set @user='admin';
update users set password = sha1(@user) where login_id = @user;

set @user='user1';
update users set password = sha1(@user) where login_id = @user;

set @user='user2';
update users set password = sha1(@user) where login_id = @user;
