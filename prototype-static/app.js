const storageKey = "zalaCMS.demo.v1";

const makeId = () => crypto.randomUUID();

const defaultState = {
  session: null,
  loginAttempts: [],
  pages: [
    {
      id: makeId(),
      title: "Tentang Kami",
      slug: "tentang-kami",
      status: "published",
      metaTitle: "Tentang ZalaCMS",
      metaDescription: "Profil singkat perusahaan dan layanan utama.",
      content: "ZalaCMS membantu bisnis mengelola halaman company profile dengan cepat."
    },
    {
      id: makeId(),
      title: "Layanan",
      slug: "layanan",
      status: "draft",
      metaTitle: "Layanan ZalaCMS",
      metaDescription: "Layanan pembuatan CMS, company profile, dan dashboard admin.",
      content: "Modul layanan siap dikembangkan menjadi halaman publik."
    }
  ],
  posts: [
    {
      id: makeId(),
      title: "Kenapa Company Profile Butuh CMS",
      category: "Insight",
      status: "published",
      excerpt: "CMS membuat tim internal bisa memperbarui konten tanpa selalu meminta developer.",
      image: "assets/zala-hero.png"
    },
    {
      id: makeId(),
      title: "Checklist Security untuk Admin Panel",
      category: "Security",
      status: "published",
      excerpt: "Validasi input, role middleware, CSRF, dan audit log adalah fondasi yang wajib ada.",
      image: "assets/zala-hero.png"
    }
  ],
  messages: [
    {
      id: makeId(),
      name: "Demo Client",
      email: "client@example.com",
      message: "Saya ingin website company profile dengan admin panel.",
      status: "unread",
      createdAt: new Date().toISOString()
    }
  ],
  users: [
    { id: makeId(), name: "Admin Zala", email: "admin@zala.test", role: "admin" },
    { id: makeId(), name: "Editor Zala", email: "editor@zala.test", role: "editor" }
  ],
  audit: [
    { id: makeId(), actor: "system", action: "Demo data dibuat", createdAt: new Date().toISOString() }
  ]
};

let state = loadState();

function loadState() {
  const stored = localStorage.getItem(storageKey);
  if (!stored) return structuredClone(defaultState);
  try { return JSON.parse(stored); } catch { return structuredClone(defaultState); }
}

function saveState() {
  localStorage.setItem(storageKey, JSON.stringify(state));
}

function escapeHtml(value = "") {
  return String(value)
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#039;");
}

function addAudit(action) {
  state.audit.unshift({
    id: makeId(),
    actor: state.session?.email || "guest",
    action,
    createdAt: new Date().toISOString()
  });
  state.audit = state.audit.slice(0, 30);
  saveState();
}

function canManageUsers() {
  return state.session?.role === "admin";
}

function requireLogin() {
  return Boolean(state.session);
}

function renderAll() {
  renderPublicNews();
  renderSession();
  renderStats();
  renderPages();
  renderPosts();
  renderMessages();
  renderUsers();
  renderAudit();
  enforceRoleUI();
}

function renderPublicNews() {
  const posts = state.posts.filter((post) => post.status === "published").slice(0, 3);
  document.querySelector("#publicNews").innerHTML = posts.map((post) => `
    <article class="news-card">
      <img src="${escapeHtml(post.image || "assets/zala-hero.png")}" alt="">
      <div>
        <span class="badge">${escapeHtml(post.category)}</span>
        <h3>${escapeHtml(post.title)}</h3>
        <p>${escapeHtml(post.excerpt)}</p>
      </div>
    </article>
  `).join("");
}

function renderSession() {
  const sessionBox = document.querySelector("#sessionBox");
  const loginPanel = document.querySelector("#loginPanel");
  if (!state.session) {
    sessionBox.innerHTML = `<span class="muted">Belum login</span>`;
    loginPanel.classList.remove("hidden");
    return;
  }

  loginPanel.classList.add("hidden");
  sessionBox.innerHTML = `
    <span><strong>${escapeHtml(state.session.name)}</strong> <span class="badge">${escapeHtml(state.session.role)}</span></span>
    <button class="button compact" type="button" id="logoutBtn">Logout</button>
  `;
  document.querySelector("#logoutBtn").addEventListener("click", () => {
    addAudit("Logout admin");
    state.session = null;
    saveState();
    renderAll();
  });
}

function renderStats() {
  const stats = [
    ["Pages", state.pages.length],
    ["Published Posts", state.posts.filter((post) => post.status === "published").length],
    ["Unread Messages", state.messages.filter((message) => message.status === "unread").length],
    ["Admin Users", state.users.length]
  ];
  document.querySelector("#statsGrid").innerHTML = stats.map(([label, value]) => `
    <div class="stat"><strong>${value}</strong><span>${label}</span></div>
  `).join("");
}

function renderTable(selector, headers, rows) {
  document.querySelector(selector).innerHTML = `
    <thead><tr>${headers.map((head) => `<th>${head}</th>`).join("")}</tr></thead>
    <tbody>${rows.length ? rows.join("") : `<tr><td colspan="${headers.length}">Belum ada data.</td></tr>`}</tbody>
  `;
}

function renderPages() {
  renderTable("#pagesTable", ["Title", "Slug", "Status", "SEO", "Actions"], state.pages.map((page) => `
    <tr>
      <td><strong>${escapeHtml(page.title)}</strong><br><span class="muted">${escapeHtml(page.content.slice(0, 90))}</span></td>
      <td>/${escapeHtml(page.slug)}</td>
      <td><span class="badge">${escapeHtml(page.status)}</span></td>
      <td>${escapeHtml(page.metaTitle)}<br><span class="muted">${escapeHtml(page.metaDescription)}</span></td>
      <td class="actions"><div class="row-actions">
        <button class="button compact" data-edit-page="${page.id}" type="button">Edit</button>
        <button class="button compact danger" data-delete-page="${page.id}" type="button">Hapus</button>
      </div></td>
    </tr>
  `));
}

function renderPosts() {
  renderTable("#postsTable", ["Title", "Category", "Status", "Excerpt", "Actions"], state.posts.map((post) => `
    <tr>
      <td><strong>${escapeHtml(post.title)}</strong></td>
      <td>${escapeHtml(post.category)}</td>
      <td><span class="badge">${escapeHtml(post.status)}</span></td>
      <td>${escapeHtml(post.excerpt)}</td>
      <td class="actions"><div class="row-actions">
        <button class="button compact" data-edit-post="${post.id}" type="button">Edit</button>
        <button class="button compact danger" data-delete-post="${post.id}" type="button">Hapus</button>
      </div></td>
    </tr>
  `));
}

function renderMessages() {
  renderTable("#messagesTable", ["Name", "Email", "Message", "Status", "Actions"], state.messages.map((message) => `
    <tr>
      <td><strong>${escapeHtml(message.name)}</strong><br><span class="muted">${new Date(message.createdAt).toLocaleString("id-ID")}</span></td>
      <td>${escapeHtml(message.email)}</td>
      <td>${escapeHtml(message.message)}</td>
      <td><span class="badge">${escapeHtml(message.status)}</span></td>
      <td class="actions"><button class="button compact" data-read-message="${message.id}" type="button">Mark read</button></td>
    </tr>
  `));
}

function renderUsers() {
  renderTable("#usersTable", ["Name", "Email", "Role", "Actions"], state.users.map((user) => `
    <tr>
      <td><strong>${escapeHtml(user.name)}</strong></td>
      <td>${escapeHtml(user.email)}</td>
      <td><span class="badge">${escapeHtml(user.role)}</span></td>
      <td class="actions"><div class="row-actions">
        <button class="button compact" data-edit-user="${user.id}" type="button">Edit</button>
        <button class="button compact danger" data-delete-user="${user.id}" type="button">Hapus</button>
      </div></td>
    </tr>
  `));
}

function renderAudit() {
  const items = state.audit.map((item) => `
    <div class="audit-item">
      <strong>${escapeHtml(item.action)}</strong>
      <small>${escapeHtml(item.actor)} - ${new Date(item.createdAt).toLocaleString("id-ID")}</small>
    </div>
  `).join("");
  document.querySelector("#auditList").innerHTML = items || `<div class="audit-item">Belum ada audit log.</div>`;
}

function enforceRoleUI() {
  const userTab = document.querySelector('[data-tab="users"]');
  const newUserBtn = document.querySelector("#newUserBtn");
  const disabled = state.session && !canManageUsers();
  userTab.disabled = Boolean(disabled);
  userTab.title = disabled ? "Hanya admin yang bisa mengelola user" : "";
  newUserBtn.disabled = Boolean(disabled);
}

function setActiveTab(tab) {
  document.querySelectorAll(".admin-tab").forEach((button) => {
    button.classList.toggle("active", button.dataset.tab === tab);
  });
  document.querySelectorAll(".admin-panel").forEach((panel) => {
    panel.classList.toggle("active", panel.id === `panel-${tab}`);
  });
}

function openForm(id) {
  if (!requireLogin()) {
    document.querySelector("#loginStatus").textContent = "Login dulu untuk mengubah data.";
    return false;
  }
  document.querySelector(`#${id}`).classList.remove("hidden");
  return true;
}

function fillForm(form, item) {
  Object.entries(item).forEach(([key, value]) => {
    if (form.elements[key] && form.elements[key].type !== "file") {
      form.elements[key].value = value;
    }
  });
}

function resetForm(formId) {
  const form = document.querySelector(`#${formId}`);
  form.reset();
  form.elements.id.value = "";
  form.classList.add("hidden");
}

function validateImage(file) {
  if (!file) return Promise.resolve("");
  const allowed = ["image/png", "image/jpeg", "image/webp"];
  if (!allowed.includes(file.type)) return Promise.reject(new Error("Upload hanya menerima PNG, JPG, atau WebP."));
  if (file.size > 2 * 1024 * 1024) return Promise.reject(new Error("Ukuran gambar maksimal 2MB untuk demo lokal."));
  return new Promise((resolve) => {
    const reader = new FileReader();
    reader.onload = () => resolve(reader.result);
    reader.readAsDataURL(file);
  });
}

document.querySelector("#loginForm").addEventListener("submit", (event) => {
  event.preventDefault();
  const form = event.currentTarget;
  const email = form.email.value.trim().toLowerCase();
  const password = form.password.value;
  const now = Date.now();
  state.loginAttempts = state.loginAttempts.filter((entry) => now - entry < 60000);

  if (state.loginAttempts.length >= 5) {
    document.querySelector("#loginStatus").textContent = "Terlalu banyak percobaan. Tunggu 1 menit.";
    saveState();
    return;
  }

  const isAdmin = email === "admin@zala.test" && password === "admin123";
  const isEditor = email === "editor@zala.test" && password === "editor123";
  if (!isAdmin && !isEditor) {
    state.loginAttempts.push(now);
    saveState();
    document.querySelector("#loginStatus").textContent = "Email atau password salah.";
    return;
  }

  const user = state.users.find((item) => item.email === email);
  state.session = user;
  state.loginAttempts = [];
  addAudit(`Login sebagai ${user.role}`);
  form.reset();
  document.querySelector("#loginStatus").textContent = "";
  renderAll();
});

document.querySelector("#contactForm").addEventListener("submit", (event) => {
  event.preventDefault();
  const form = event.currentTarget;
  state.messages.unshift({
    id: makeId(),
    name: form.name.value.trim(),
    email: form.email.value.trim(),
    message: form.message.value.trim(),
    status: "unread",
    createdAt: new Date().toISOString()
  });
  addAudit("Pesan kontak baru diterima");
  form.reset();
  document.querySelector("#contactStatus").textContent = "Pesan tersimpan ke dashboard admin.";
  renderAll();
});

document.querySelectorAll(".admin-tab").forEach((button) => {
  button.addEventListener("click", () => {
    if (!button.disabled) setActiveTab(button.dataset.tab);
  });
});

document.querySelector("#newPageBtn").addEventListener("click", () => {
  if (openForm("pageForm")) {
    resetForm("pageForm");
    document.querySelector("#pageForm").classList.remove("hidden");
  }
});

document.querySelector("#newPostBtn").addEventListener("click", () => {
  if (openForm("postForm")) {
    resetForm("postForm");
    document.querySelector("#postForm").classList.remove("hidden");
  }
});

document.querySelector("#newUserBtn").addEventListener("click", () => {
  if (!canManageUsers()) return;
  if (openForm("userForm")) {
    resetForm("userForm");
    document.querySelector("#userForm").classList.remove("hidden");
  }
});

document.querySelectorAll("[data-cancel]").forEach((button) => {
  button.addEventListener("click", () => resetForm(button.dataset.cancel));
});

document.querySelector("#pageForm").addEventListener("submit", (event) => {
  event.preventDefault();
  if (!requireLogin()) return;
  const form = event.currentTarget;
  const payload = {
    id: form.id.value || makeId(),
    title: form.title.value.trim(),
    slug: form.slug.value.trim().toLowerCase(),
    status: form.status.value,
    metaTitle: form.metaTitle.value.trim(),
    metaDescription: form.metaDescription.value.trim(),
    content: form.content.value.trim()
  };
  const index = state.pages.findIndex((item) => item.id === payload.id);
  if (index >= 0) state.pages[index] = payload;
  else state.pages.unshift(payload);
  addAudit(`${index >= 0 ? "Update" : "Tambah"} page: ${payload.title}`);
  resetForm("pageForm");
  renderAll();
});

document.querySelector("#postForm").addEventListener("submit", async (event) => {
  event.preventDefault();
  if (!requireLogin()) return;
  const form = event.currentTarget;
  try {
    const existing = state.posts.find((item) => item.id === form.id.value);
    const image = await validateImage(form.image.files[0]);
    const payload = {
      id: form.id.value || makeId(),
      title: form.title.value.trim(),
      category: form.category.value.trim(),
      status: form.status.value,
      excerpt: form.excerpt.value.trim(),
      image: image || existing?.image || "assets/zala-hero.png"
    };
    const index = state.posts.findIndex((item) => item.id === payload.id);
    if (index >= 0) state.posts[index] = payload;
    else state.posts.unshift(payload);
    addAudit(`${index >= 0 ? "Update" : "Tambah"} artikel: ${payload.title}`);
    resetForm("postForm");
    renderAll();
  } catch (error) {
    alert(error.message);
  }
});

document.querySelector("#userForm").addEventListener("submit", (event) => {
  event.preventDefault();
  if (!canManageUsers()) return;
  const form = event.currentTarget;
  const payload = {
    id: form.id.value || makeId(),
    name: form.name.value.trim(),
    email: form.email.value.trim().toLowerCase(),
    role: form.role.value
  };
  const index = state.users.findIndex((item) => item.id === payload.id);
  if (index >= 0) state.users[index] = payload;
  else state.users.unshift(payload);
  addAudit(`${index >= 0 ? "Update" : "Tambah"} user: ${payload.email}`);
  resetForm("userForm");
  renderAll();
});

document.querySelector(".admin-main").addEventListener("click", (event) => {
  const button = event.target.closest("button");
  if (!button || !requireLogin()) return;

  if (button.dataset.editPage) {
    fillForm(document.querySelector("#pageForm"), state.pages.find((entry) => entry.id === button.dataset.editPage));
    document.querySelector("#pageForm").classList.remove("hidden");
    return;
  }
  if (button.dataset.editPost) {
    fillForm(document.querySelector("#postForm"), state.posts.find((entry) => entry.id === button.dataset.editPost));
    document.querySelector("#postForm").classList.remove("hidden");
    return;
  }
  if (button.dataset.editUser && canManageUsers()) {
    fillForm(document.querySelector("#userForm"), state.users.find((entry) => entry.id === button.dataset.editUser));
    document.querySelector("#userForm").classList.remove("hidden");
    return;
  }
  if (button.dataset.deletePage) {
    state.pages = state.pages.filter((page) => page.id !== button.dataset.deletePage);
    addAudit("Hapus page");
  }
  if (button.dataset.deletePost) {
    state.posts = state.posts.filter((post) => post.id !== button.dataset.deletePost);
    addAudit("Hapus artikel");
  }
  if (button.dataset.deleteUser && canManageUsers()) {
    state.users = state.users.filter((user) => user.id !== button.dataset.deleteUser);
    addAudit("Hapus user");
  }
  if (button.dataset.readMessage) {
    const message = state.messages.find((item) => item.id === button.dataset.readMessage);
    if (message) message.status = "read";
    addAudit("Tandai pesan sebagai read");
  }
  saveState();
  renderAll();
});

document.querySelector("#clearMessagesBtn").addEventListener("click", () => {
  if (!requireLogin()) return;
  state.messages = state.messages.filter((message) => message.status !== "read");
  addAudit("Bersihkan pesan read");
  renderAll();
});

document.querySelector("#resetDemoBtn").addEventListener("click", () => {
  state = structuredClone(defaultState);
  saveState();
  renderAll();
});

renderAll();
