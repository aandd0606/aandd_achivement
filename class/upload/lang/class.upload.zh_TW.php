<?php
// +------------------------------------------------------------------------+
// | class.upload.zh_TW.php                                                 |
// +------------------------------------------------------------------------+
// | Copyright (c) Yang Chih-Wen 2009. All rights reserved.                 |
// | Version       0.25                                                     |
// | Last modified 03/04/2009                                               |
// | Email         chihwen.yang@gmail.com                                   |
// | Web           http://www.doubleservice.com/                            |
// +------------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify   |
// | it under the terms of the GNU General Public License version 2 as      |
// | published by the Free Software Foundation.                             |
// |                                                                        |
// | This program is distributed in the hope that it will be useful,        |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of         |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the          |
// | GNU General Public License for more details.                           |
// |                                                                        |
// | You should have received a copy of the GNU General Public License      |
// | along with this program; if not, write to the                          |
// |   Free Software Foundation, Inc., 59 Temple Place, Suite 330,          |
// |   Boston, MA 02111-1307 USA                                            |
// |                                                                        |
// | Please give credit on sites that use class.upload and submit changes   |
// | of the script so other people can use them as well.                    |
// | This script is free to use, don't abuse.                               |
// +------------------------------------------------------------------------+

/**
 * Class upload Traditional Chinese translation
 *
 * @version   0.25
 * @author    Yang Chih-Wen (chihwen.yang@gmail.com)
 * @license   http://opensource.org/licenses/gpl-license.php GNU Public License
 * @copyright Yang Chih-Wen
 * @package   cmf
 * @subpackage external
 */

    $translation = array();
    $translation['file_error']                  = '�ɮ׿��~�A�Э��աC';
    $translation['local_file_missing']          = '���a�ݪ��ɮפ��s�b�C';
    $translation['local_file_not_readable']     = '���a�ݪ��ɮפ��iŪ���C';
    $translation['uploaded_too_big_ini']        = '�ɮפW�ǥX�� (�W�Ǫ��ɮ׶W�L�F php.ini �� upload_max_filesize ���w���j�p)�C';
    $translation['uploaded_too_big_html']       = '�ɮפW�ǥX�� (�W�Ǫ��ɮ׶W�L�F HTML ��椤 MAX_FILE_SIZE ���w���j�p)�C';
    $translation['uploaded_partial']            = '�ɮפW�ǥX�� (�u���������ɮ׳Q�W��)�C';
    $translation['uploaded_missing']            = '�ɮפW�ǥX�� (�S���ɮ׳Q�W��)�C';
    $translation['uploaded_unknown']            = '�ɮפW�ǥX�� (���������~)�C';
    $translation['try_again']                   = '�ɮפW�ǥX���A�Э��աC';
    $translation['file_too_big']                = '�ɮפӤj�F�C';
    $translation['no_mime']                     = '������ MIME Type �ɮ������C';
    $translation['incorrect_file']              = '�����T�� MIME Type �ɮ������C';
    $translation['image_too_wide']              = '�Ϥ��e�פӤj�C';
    $translation['image_too_narrow']            = '�Ϥ��e�פӤp�C';
    $translation['image_too_high']              = '�Ϥ����פӤj�C';
    $translation['image_too_short']             = '�Ϥ����פӤp�C';
    $translation['ratio_too_high']              = '�Ϥ��e����v�Ӥj (�Ϥ��e�פӤj)�C';
    $translation['ratio_too_low']               = '�Ϥ��e����v�Ӥp (�Ϥ����פӤj)�C';
    $translation['too_many_pixels']             = '�Ϥ������Ӧh�C';
    $translation['not_enough_pixels']           = '�Ϥ������Ӥ֡C';
    $translation['file_not_uploaded']           = '�ɮץ��W�ǡA�L�k�~��i��B�z�C';
    $translation['already_exists']              = '%s �w�g�s�b�A�Ч���ɦW�C';
    $translation['temp_file_missing']           = '�Ȧs����l�ɮפ����T�A�L�k�~��i��B�z�C';
    $translation['source_missing']              = '�w�W�Ǫ���l�ɮפ����T�A�L�k�~��i��B�z�C';
    $translation['destination_dir']             = '�L�k�ЫإؼХؿ��A�L�k�~��i��B�z�C';
    $translation['destination_dir_missing']     = '�ؼХؿ����s�b�A�L�k�~��i��B�z�C';
    $translation['destination_path_not_dir']    = '�ؼи��|���O�@�Ӧ��Ī��ؿ��A�L�k�~��i��B�z�C';
    $translation['destination_dir_write']       = '�ؼХؿ�����]�w���i�g�J�A�L�k�~��i��B�z�C';
    $translation['destination_path_write']      = '�ؿ����|���i�g�J�A�L�k�~��i��B�z�C';
    $translation['temp_file']                   = '����ЫؼȦs�ɮסA�L�k�~��i��B�z�C';
    $translation['source_not_readable']         = '��l�ɮפ��iŪ���A�L�k�~��i��B�z�C';
    $translation['no_create_support']           = '���䴩 %s �Ыإ\��C';
    $translation['create_error']                = '�q��l�ɮ׳Ы� %s �Ϥ��L�{���X���C';
    $translation['source_invalid']              = '�L�kŪ����l�Ϥ��A�нT�{�O�_�����T���Ϥ��ɡH';
    $translation['gd_missing']                  = '�L�k�ϥ� GD �禡�w�C';
    $translation['watermark_no_create_support'] = '���䴩 %s �Ыإ\��A�L�kŪ���B���L�C';
    $translation['watermark_create_error']      = '���䴩 %s Ū���\��A�L�k�ЫدB���L�C';
    $translation['watermark_invalid']           = '�������Ϥ��榡�A�L�kŪ���B���L�C';
    $translation['file_create']                 = '���䴩 %s �Ыإ\��C';
    $translation['no_conversion_type']          = '���w�q���ഫ�����C';
    $translation['copy_failed']                 = '�b���A�ݽƻs�ɮ׮ɥX���Acopy() �ާ@���ѡC';
    $translation['reading_failed']              = 'Ū�ɹL�{���X���C';
?>
