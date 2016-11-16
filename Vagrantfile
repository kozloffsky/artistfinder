# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.box = "debian/jessie64"
  config.vm.network "private_network", ip: "192.168.33.12"
  config.vm.synced_folder ".", "/vagrant", type: "rsync",
      rsync__exclude: [".git/", "app/cache", "app/logs"]
  config.vm.provision :shell, path: "bootstrap.sh"
  config.vm.provider "virtualbox" do |v|
	  v.memory = 1024
  end
end
