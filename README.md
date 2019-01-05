# OpenWRT-ExtRoot
OpenWRT-ExtRoot

Install Packages:
	
	opkg update
	opkg install kmod-usb-storage kmod-fs-ext4 block-mount
	
Find the name of your flash drive with the : block info
	
	block info
		/dev/mtdblock2: UUID="20ad40ea-d33a421e-785b7d2d-ada99230" VERSION="4.0" TYPE="squashfs" /dev/mtdblock3: TYPE="jffs2"
		/dev/sda1: UUID="9fa36631-ac09-42a0-b090-f61efe6c1bfb" NAME="EXT_USB" VERSION="1.0" TYPE="ext4" 

Create a directory and mount your device on it:
	
	mkdir -p /mnt/flash
	mount -t ext4 /dev/sda2 /mnt/flash

Copy the router's internal flash to the flash drive :
	
	mkdir -p /tmp/cproot
	mount --bind / /tmp/cproot
	tar -C /tmp/cproot -cvf - . | tar -C /mnt/flash -xf -
	umount /tmp/cproot

Edit /etc/config/fstab file :
	
	vi /etc/config/fstab

Add the following changes:

	config global
		option delay_root 1

	config global automount
	option from_fstab 1
	option anon_mount 1

	config global autoswap
  	option from_fstab 1
  	option anon_swap 0

	config mount
  	option target   /
  	option device   /dev/sda1
  	option fstype   ext4
  	option options  rw,sync
  	option enabled  1
  	option enabled_fsck 0

Enable and Start fstab :

	/etc/init.d/fstab enable
	/etc/init.d/fstab start

Restart the router :

	reboot -f

After booting and login, check the mount point: 
	
	mount

You should see that /dev/sda1 has been mounted on /

You are done :) 
