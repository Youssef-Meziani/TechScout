# Get the project up and running on Windows 11 using WSL

1. **WSL installation & setup :**
    ```powershell
    dism.exe /online /enable-feature /featurename:Microsoft-Windows-Subsystem-Linux /all /norestart

    dism.exe /online /enable-feature /featurename:VirtualMachinePlatform /all /norestart

    wsl --set-default-version 2

    # Restart the PC

    wsl --install -d Ubuntu
    ```

2. **Install Docker Desktop on Windows.**


3. **Install Lando in Ubuntu distro :**
    ```bash
    sudo apt get update

    wget https://files.lando.dev/lando-x64-stable.deb

    sudo apt install -y php

    sudo apt install -y composer
    ```

4. **Clone the project inside the user folder on the Ubuntu distro.**
5. **Open a terminal in the project folder and run :**
    ```bash
    lando setup

    lando start

    lando composer install
    ```
6. **Import drupal configuration by running :**
    ```bash
    lando drush config:import
    
    lando drush cache:rebuild
    ```
