<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم المدير</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .login-box {
            width: 300px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .login-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        #adminPanel {
            display: none; /* إخفاء لوحة التحكم عند البداية */
        }
        .book-item:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body>
<button id="back-to-top" onclick="scrollToTop()">⬆</button>

<header>
    <h1>نافذة على إسرائيل</h1>
    <h4>مدونة الدراسات اليهودية والإسرائيلية</h4>
</header>

    <!-- شاشة تسجيل الدخول -->
    <div id="loginScreen" class="login-container">
        <div class="login-box">
            <h2>تسجيل الدخول</h2>
            <form id="loginForm">
                <div class="mb-3">
                    <label for="username" class="form-label">اسم المستخدم</label>
                    <input type="text" class="form-control" id="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">كلمة المرور</label>
                    <input type="password" class="form-control" id="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">دخول</button>
            </form>
        </div>
    </div>

    <!-- لوحة تحكم المدير -->
    <div id="adminPanel">
        <h1 class="text-center my-4">لوحة تحكم المدير</h1>

        <!-- إضافة كتاب -->
        <div class="container mb-5">
            <h4>إضافة كتاب جديد</h4>
            <form id="addBookForm">
                <div class="mb-3">
                    <label for="bookTitle" class="form-label">اسم الكتاب</label>
                    <input type="text" class="form-control" id="bookTitle" required>
                </div>
                <div class="mb-3">
                    <label for="bookDescription" class="form-label">وصف الكتاب</label>
                    <textarea class="form-control" id="bookDescription" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="bookAuthor" class="form-label">اسم المؤلف</label>
                    <input type="text" class="form-control" id="bookAuthor" required>
                </div>
                <div class="mb-3">
                    <label for="bookKeywords" class="form-label">الكلمات المفتاحية</label>
                    <input type="text" class="form-control" id="bookKeywords" required>
                </div>
                <div class="mb-3">
                    <label for="bookImage" class="form-label">صورة الكتاب</label>
                    <input type="file" class="form-control" id="bookImage" required>
                </div>
                <div class="mb-3">
                    <label for="bookFile" class="form-label">ملف الكتاب (PDF)</label>
                    <input type="file" class="form-control" id="bookFile" required>
                </div>
                <button type="submit" class="btn btn-success">إضافة الكتاب</button>
            </form>
        </div>

        <!-- حذف كتاب -->
        <div class="container mb-5">
            <h4>حذف كتاب</h4>
            <input type="text" id="deleteBookTitle" class="form-control" placeholder="أدخل اسم الكتاب الذي تريد حذفه">
            <button type="button" class="btn btn-danger mt-3" onclick="deleteBook()">حذف الكتاب</button>
        </div>

        <!-- عرض الكتب -->
        <div id="booksContainer" class="row mt-4">
            <!-- سيتم إضافة الكتب هنا -->
        </div>
    </div>

    <script>
        // بيانات المستخدم الافتراضية
        const validUsername = "admin";
        const validPassword = "12345";  // كلمة مرور افتراضية

        // التحقق من حالة تسجيل الدخول عند تحميل الصفحة
        window.onload = function() {
            if (sessionStorage.getItem('isLoggedIn') === 'true') {
                showAdminPanel();
            } else {
                showLoginScreen();
            }
        };

        // عرض شاشة تسجيل الدخول
        function showLoginScreen() {
            document.getElementById('loginScreen').style.display = 'flex';
            document.getElementById('adminPanel').style.display = 'none';
        }

        // عرض لوحة تحكم المدير
        function showAdminPanel() {
            document.getElementById('loginScreen').style.display = 'none';
            document.getElementById('adminPanel').style.display = 'block';
            displayBooks(); // عرض الكتب المخزنة
        }

        // تسجيل الدخول
        document.getElementById('loginForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            if (username === validUsername && password === validPassword) {
                sessionStorage.setItem('isLoggedIn', 'true');
                showAdminPanel();  // إذا كانت البيانات صحيحة، اعرض لوحة التحكم
            } else {
                alert('اسم المستخدم أو كلمة المرور غير صحيحة');
            }
        });

        // إضافة كتاب
        document.getElementById('addBookForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const bookTitle = document.getElementById('bookTitle').value;
            const bookDescription = document.getElementById('bookDescription').value;
            const bookAuthor = document.getElementById('bookAuthor').value;
            const bookKeywords = document.getElementById('bookKeywords').value;
            const bookImage = document.getElementById('bookImage').files[0];
            const bookFile = document.getElementById('bookFile').files[0];

            const validImageTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (bookImage && !validImageTypes.includes(bookImage.type)) {
                alert('يرجى تحميل صورة بصيغة صحيحة (JPEG, PNG, JPG, GIF).');
                return;
            }

            if (bookFile && bookFile.type !== 'application/pdf') {
                alert('يرجى تحميل ملف بصيغة PDF.');
                return;
            }

            let books = JSON.parse(localStorage.getItem('books')) || [];
            const newBook = {
                title: bookTitle,
                description: bookDescription,
                author: bookAuthor,
                keywords: bookKeywords,
                image: URL.createObjectURL(bookImage),
                file: URL.createObjectURL(bookFile)
            };
            books.push(newBook);
            localStorage.setItem('books', JSON.stringify(books));

            displayBooks();
            alert("تم إضافة الكتاب بنجاح");
        });

        // عرض الكتب في صفحة المراجع
        function displayBooks() {
            const booksContainer = document.getElementById('booksContainer');
            booksContainer.innerHTML = '';

            const books = JSON.parse(localStorage.getItem('books')) || [];
            books.forEach(book => {
                const bookCard = document.createElement('div');
                bookCard.classList.add('col-md-4', 'mb-4', 'book-item');
                bookCard.setAttribute('data-title', book.title);

                bookCard.innerHTML = `
                    <div class="card">
                        <img src="${book.image}" class="card-img-top" alt="صورة الكتاب">
                        <div class="card-body">
                            <h5 class="card-title">${book.title}</h5>
                            <p class="card-text">${book.description}</p>
                            <a href="${book.file}" class="btn btn-primary" target="_blank">تحميل الكتاب</a>
                            <button class="btn btn-info mt-2" onclick="showDetails('${book.title}')">عرض التفاصيل</button>
                        </div>
                    </div>
                `;

                booksContainer.appendChild(bookCard);
            });
        }

        // عرض تفاصيل الكتاب في النافذة المنبثقة
        function showDetails(bookTitle) {
            const books = JSON.parse(localStorage.getItem('books')) || [];
            const book = books.find(b => b.title === bookTitle);

            if (book) {
                document.getElementById('modalBookImage').src = book.image;
                document.getElementById('modalBookTitle').textContent = book.title;
                document.getElementById('modalBookDescription').textContent = book.description;
                document.getElementById('modalBookAuthor').textContent = book.author;
                document.getElementById('modalBookKeywords').textContent = book.keywords;
                document.getElementById('modalBookFile').href = book.file;

                const myModal = new bootstrap.Modal(document.getElementById('bookDetailsModal'));
                myModal.show();
            }
        }

        // دالة حذف كتاب
        function deleteBook() {
            const deleteBookTitle = document.getElementById('deleteBookTitle').value;
            let books = JSON.parse(localStorage.getItem('books')) || [];

            books = books.filter(book => book.title !== deleteBookTitle);
            localStorage.setItem('books', JSON.stringify(books));

            displayBooks();
            alert("تم حذف الكتاب بنجاح");
        }
    </script>
<!-- Footer Section -->
<div class="footer">
       <p>مدونة نافذة على إسرائيل. جميع الحقوق محفوظة 2024 &copy; </p>
   </div>
</body>
</html>
