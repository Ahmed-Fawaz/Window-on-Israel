// البحث عن الكتب
function searchBooks(event) {
    event.preventDefault();
    const query = document.getElementById('search').value.toLowerCase();
    const filteredBooks = books.filter(book => 
        book.title.toLowerCase().includes(query) || 
        book.keywords.some(keyword => keyword.toLowerCase().includes(query))
    );
    displayFilteredBooks(filteredBooks);
}

// عرض الكتب المفلترة
function displayFilteredBooks(filteredBooks) {
    const bookContainer = document.getElementById('book-list');
    bookContainer.innerHTML = ''; // مسح القائمة الحالية
    filteredBooks.forEach((book, index) => {
        const bookElement = document.createElement('div');
        bookElement.className = 'book';
        bookElement.innerHTML = `
            <img src="${book.coverUrl}" alt="${book.title}" onclick="openBookDetails(${index})">
            <h3>${book.title}</h3>
        `;
        bookContainer.appendChild(bookElement);
    });
}

// التحقق من إدخال نص البحث
function validateSearchInput(event) {
    const inputField = document.getElementById("search-input");
    const errorMessage = document.getElementById("error-message");

    if (inputField.value.trim() === "") {
        errorMessage.textContent = "الرجاء إدخال نص للبحث.";
        errorMessage.style.display = "block";
        return false;
    }

    if (inputField.value.length < 3) {
        errorMessage.textContent = "يجب أن يحتوي النص على 3 أحرف على الأقل.";
        errorMessage.style.display = "block";
        return false;
    }

    errorMessage.style.display = "none";
    return true;
}

// عرض شاشة الانتظار وزر التحميل
function showDownload(bookIndex) {
    const waitingScreen = document.getElementById('waiting-screen');
    const downloadButton = document.getElementById('download-button');
    const downloadLink = document.getElementById('download-link');

    waitingScreen.style.display = 'block';
    setTimeout(() => {
        waitingScreen.style.display = 'none';
        downloadButton.style.display = 'none';
        downloadLink.style.display = 'block';
        downloadLink.href = books[bookIndex].fileUrl;
    }, 10000);
}

// إنشاء صفحة تفاصيل الكتاب
function openBookDetails(index) {
    const book = books[index];
    const detailsWindow = window.open('', '_blank');
    
    detailsWindow.document.write(`
        <!DOCTYPE html>
        <html lang="ar" dir="rtl">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="monetag" content="318815853dacbb3efced8f324018e9c5">
            <link rel="stylesheet" href="style.css">
            <title>${book.title}</title>
            <style>
              :root {
            --background-light: #ffffff;
            --text-light: #000000;
            --background-dark: #121212;
            --text-dark: #ffffff;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background-light);
            color: var(--text-light);
            transition: background-color 0.3s, color 0.3s;
        }

        body.dark-mode {
            background-color: var(--background-dark);
            color: var(--text-dark);
        }

        .toggle-button {
            position: fixed;
            top: 10px;
            left: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .toggle-button:hover {
            background-color: #0056b3;
        }
                body { font-family: Arial, sans-serif; line-height: 1.6; margin: 20px; text-align: center; }
                .button { display: inline-block; padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px; }
                .button:hover { background: #218838; }
                #waiting-screen { text-align: center; display: none; }
            </style>
        </head>
        <body>
        <button class="toggle-button" onclick="toggleTheme()">تبديل الوضع</button>
        <button id="back-to-top" onclick="scrollToTop()">⬆</button>

        <header>
        <h1>نافذة على إسرائيل</h1>
        <h4>مدونة الدراسات اليهودية والإسرائيلية</h4>
    </header>
    <nav>
        <ul>
            <li><a href="index.html">الصفحة الرئيسية</a></li>
            <li class="dropdown">
                <a href="books.html">المصادر والمراجع</a>
                <ul class="dropdown-content">
                    <li><a href="#" onclick="navigateToSection('كتب قواعد اللغة العبرية')">كتب قواعد اللغة العبرية</a></li>
                    <li><a href="#" onclick="navigateToSection('تاريخ يهودي')">تاريخ يهودي</a></li>
                    <li><a href="#" onclick="navigateToSection('كتب الأدب العبري')">كتب الأدب العبري</a></li>
                    <li><a href="#" onclick="navigateToSection('كتب الديانة اليهودية')">كتب الديانة اليهودية</a></li>
                    <li><a href="#" onclick="navigateToSection('الصهيونية')">الصهيونية</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">المقالات الأكاديمية</a>
                <ul class="dropdown-content">
                    <li><a href="old-hebrew-literature-articles.html">الأدب العبري</a></li>
                    <li><a href="medieval-hebrew-literature-articles.html">الديانة اليهودية</a></li>
                    <li><a href="modern-hebrew-literature-articles.html">مقالات رأي</a></li>
                </ul>
            </li>
            <li><a href="contact.html">أخبار مترجمة من الصحف العبرية</a></li>
            <li><a href="contact.html">التواصل</a></li>
            <li><a href="signup.html">إنشاء حساب</a></li>
        </ul>
    </nav>

    
    <!-- Ad Space at the Top -->
    <div class="ad" style="text-align: center; margin-top: 10px;">Ad Space - Top</div>
<div class="container">
           <img src="${book.coverUrl}" alt="${book.title}" style="width:200px; height:auto; margin-bottom:10px;">
            <h1>${book.title}</h1>
            <p><strong>الوصف:</strong> ${book.description}</p>
            <p><strong>المؤلف:</strong> ${book.author}</p>
            <p><strong>الكلمات المفتاحية:</strong> ${book.keywords.join(', ')}</p>
            <a href="#" id="download-button" class="button" onclick="showDownload(${index})">تحميل</a>
            <a href="${book.readUrl}" target="_blank" class="button">قراءة الكتاب</a>
            <div id="waiting-screen">
                <p>الرجاء الانتظار، يتم تحضير الكتاب للتحميل...</p>
                <div style="height: 100px;">إعلانات هنا</div>
            </div>
            <a id="download-link" href="#" download class="button" style="display:none;">اضغط للتحميل</a>
            </div>  
             <!-- Ad Space at the Bottom -->
   <div class="ad" style="text-align: center; margin-top: 20px;">Ad Space - Bottom</div>

   <!-- Footer Section -->
   <div class="footer">
       <p>مدونة نافذة على إسرائيل. جميع الحقوق محفوظة 2024 &copy; </p>
   </div>
        </body>
        </html>
    `);
}

// عرض الكتب
function displayBooks() {
    const bookContainer = document.getElementById('book-list');
    books.forEach((book, index) => {
        const bookElement = document.createElement('div');
        bookElement.className = 'book';
        bookElement.style = "display: inline-block; margin: 10px; text-align: center;";
        bookElement.innerHTML = `
            <img src="${book.coverUrl}" alt="${book.title}" style="width: 150px; height: 200px; object-fit: cover; cursor: pointer;" onclick="openBookDetails(${index})">
            <h3>${book.title}</h3>
        `;
        bookContainer.appendChild(bookElement);
    });
}

// التبديل بين الوضع الفاتح والداكن
function toggleTheme() {
    document.body.classList.toggle('dark-mode');
    const isDarkMode = document.body.classList.contains('dark-mode');
    localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
}

// استعادة الحالة عند التحميل
window.onload = () => {
    displayBooks();
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        document.body.classList.add('dark-mode');
    }
};

// التحكم بزر العودة للأعلى
window.onscroll = function() {
    const backToTop = document.getElementById("back-to-top");
    if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
        backToTop.style.display = "block";
    } else {
        backToTop.style.display = "none";
    }
};

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: "smooth" });
}

// تعريف بيانات الكتب
const books = [
    {
        title: "موسوعة اليهود واليهودية والصهيونية - المجلد الأول",
        description: "كتاب يتناول تاريخ اليهود عبر العصور.",
        author: "د.عبدالوهاب المسيري",
        keywords: ["تاريخ", "تاريخ يهودي", "يهود", "حضارة"],
        coverUrl: "covers/cover.jpeg",
        fileUrl: "books/موسوعة_اليهود_واليهودية_و_الصهيونية_ج١.pdf",
        readUrl: "books/موسوعة_اليهود_واليهودية_و_الصهيونية_ج١.pdf"
    },
    {
        title: "موسوعة اليهود واليهودية والصهيونية - المجلد الثاني",
        description: "دراسة معمقة في الأدب العبري.",
        author: "د.عبدالوهاب المسيري",
        keywords: ["أدب عبري", "الشعر", "النثر"],
        coverUrl: "covers/cover.jpeg",
        fileUrl: "books/موسوعه_اليهود_واليهودية_و_الصهيونية_ج٢.pdf",
        readUrl: "books/موسوعه_اليهود_واليهودية_و_الصهيونية_ج٢.pdf"
    }
];
