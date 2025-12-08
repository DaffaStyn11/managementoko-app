    <script>
        const sidebar = document.getElementById("sidebar");
        const mainContent = document.getElementById("mainContent");
        const sidebarTitle = document.getElementById("sidebarTitle");
        const menuList = document.getElementById("menuList");
        const toggleSidebar = document.getElementById("toggleSidebar");
        const toggleIcon = document.getElementById("toggleIcon");

        let isCollapsed = false;

        toggleSidebar.addEventListener("click", () => {
            isCollapsed = !isCollapsed;

            if (isCollapsed) {
                sidebar.classList.add("sidebar-collapsed");
                sidebar.classList.remove("sidebar-expanded");

                mainContent.classList.add("ml-[72px]");
                mainContent.classList.remove("ml-64");

                sidebarTitle.classList.add("hidden");
                menuList.querySelectorAll("span").forEach(el => el.classList.add("hidden"));

                toggleIcon.dataset.feather = "x";
            } else {
                sidebar.classList.add("sidebar-expanded");
                sidebar.classList.remove("sidebar-collapsed");

                mainContent.classList.add("ml-64");
                mainContent.classList.remove("ml-[72px]");

                sidebarTitle.classList.remove("hidden");
                menuList.querySelectorAll("span").forEach(el => el.classList.remove("hidden"));

                toggleIcon.dataset.feather = "menu";
            }

            feather.replace();
        });

        // Dropdown admin
        const adminBtn = document.getElementById("adminButton");
        const dropdown = document.getElementById("adminDropdown");

        adminBtn.addEventListener("click", () => {
            dropdown.classList.toggle("hidden");
        });

        document.addEventListener("click", e => {
            if (!adminBtn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add("hidden");
            }
        });

        feather.replace();
    </script>
