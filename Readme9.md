1. **$limit, $page, $offset dùng để làm gì?**
- `$limit`: Số lượng bản ghi (sản phẩm, danh mục...) hiển thị trên 1 trang.
- `$page`: Trang hiện tại mà người dùng đang xem.
- `$offset`: Vị trí bắt đầu lấy dữ liệu trong Database cho trang hiện tại (bỏ qua các bản ghi của các trang trước đó).

2. **Vì sao cần ceil() khi tính $totalPages?**
- Hàm `ceil()` dùng để làm tròn lên. Nếu tổng số bản ghi chia cho `$limit` ra số lẻ (VD: 2.1 trang), thì ta cần làm tròn lên thành 3 trang để chứa hết phần dư (0.1) đó.

3. **LIMIT và OFFSET trong SQL có tác dụng gì?**
- `LIMIT`: Giới hạn số dòng dữ liệu trả về từ câu truy vấn.
- `OFFSET`: Bỏ qua một số dòng dữ liệu đầu tiên trước khi bắt đầu lấy dữ liệu. Kết hợp cả hai để tạo ra chức năng phân trang.

4. **Vì sao khi chuyển trang phải giữ limit trên URL?**
- Để hệ thống biết người dùng đang muốn hiển thị bao nhiêu dòng trên 1 trang (VD: 10, 20 hay 30). Nếu không giữ, hệ thống sẽ reset về giá trị mặc định (VD: 10), làm vỡ logic hiển thị mà người dùng đã chọn trước đó.

5. **Vì sao khi tìm kiếm phải giữ keyword khi chuyển trang?**
- Để người dùng có thể xem kết quả tìm kiếm ở các trang tiếp theo (trang 2, trang 3 của kết quả tìm kiếm). Nếu mất keyword, khi bấm sang trang 2, hệ thống sẽ hiển thị toàn bộ dữ liệu chứ không phải dữ liệu đang được lọc.

6. **count() dùng để làm gì trong chức năng phân trang?**
- Dùng để đếm TỔNG SỐ bản ghi có trong bảng (hoặc tổng số bản ghi thỏa điều kiện tìm kiếm). Từ tổng số này, ta mới tính được tổng số trang (`$totalPages`).

7. **Vì sao nên tái sử dụng getPage() thay vì tạo getPageByKeyword() riêng?**
- Việc gộp chung giúp giảm lặp code (DRY - Don't Repeat Yourself). Ta chỉ cần viết câu SQL có xét thêm điều kiện `if (!empty($keyword))` và truyền vào tham số thay vì phải bảo trì 2 hàm gần như y hệt nhau.

8. **Khi tìm kiếm không có kết quả thì $totalPages có giá trị bao nhiêu?**
- Bằng `0` (vì tổng số bản ghi = 0, chia cho `$limit` thì `$totalPages` = 0).

9. **sort dùng để làm gì?**
- Dùng để truyền chỉ thị sắp xếp dữ liệu (VD: sắp xếp theo giá tăng dần, giá giảm dần, tên A-Z) vào câu lệnh SQL (`ORDER BY`).

10. **Khi kết hợp tìm kiếm + sắp xếp + phân trang, những tham số nào cần được giữ trên URL?**
- Cần giữ lại tất cả: `keyword` (từ khóa tìm kiếm), `limit` (số dòng/trang), `sort` (kiểu sắp xếp) và `page` (trang muốn tới). VD URL: `?keyword=abc&limit=20&sort=price_asc&page=2`.
