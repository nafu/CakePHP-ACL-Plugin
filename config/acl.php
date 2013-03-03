<?php

//acl関連の設定



//グループ管理用テーブル
Configure :: write('acl.aro.role.model', 'AdminGroup');
//グループの表示名
Configure :: write('acl.aro.role.display_field', 'name');
//グループの主キー
Configure :: write('acl.aro.role.primary_key', '');



//ユーザー管理用テーブル
Configure :: write('acl.aro.user.model', 'AdminUser');
//ユーザーの表示名
Configure :: write('acl.user.display_name', "username");
//ユーザーの主キー
Configure :: write('acl.aro.user.primary_key', '');



// 特別権限設定・・・全アクセス権限付与。
// 詳細の権限管理はDB管理のため、ここを頻繁に変更するのは推奨しない。
Configure :: write('acl.role.access_all_role_ids', array());
Configure :: write('acl.role.access_all_user_ids', array(1));
