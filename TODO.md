# TODO: Upgrade Admin IDs with Crypt Decrypt

## Tasks

-   [x] Update UserController to use Crypt for decrypting IDs in methods (edit, update, destroy, approve, reject)
-   [x] Update resources/views/admin/users/index.blade.php to encrypt IDs in action links
-   [x] Update resources/views/admin/users/edit.blade.php to encrypt ID in form action
-   [x] Update TokoController to use Crypt for decrypting IDs
-   [x] Update KategoriController to use Crypt for decrypting IDs
-   [x] Update ProdukController to use Crypt for decrypting IDs
-   [x] Update GambarProdukController to use Crypt for decrypting IDs
-   [x] Update TestimoniController to use Crypt for decrypting IDs
-   [x] Update all admin views to encrypt IDs in links and forms
-   [x] Update public views to encrypt IDs in links (produk and toko show)
-   [x] Update PublicController to decrypt IDs for show methods
-   [x] Update member views to encrypt IDs in links (produk and toko show)
-   [x] Update MemberController to decrypt IDs for produk methods (edit, update, destroy)
-   [x] Update home.blade.php to encrypt IDs in produk and toko links
-   [x] Update public produk and toko show views to encrypt IDs in links
-   [x] Update public produk index view to encrypt IDs in produk links
-   [x] Update PublicController indexProduk to decrypt kategori ID in filter
-   [x] Update public produk index view to encrypt kategori IDs in filter links
-   [ ] Test encrypted links work correctly
-   [ ] Verify decryption handles invalid encrypted strings gracefully
-   [ ] Ensure pagination and other features remain unaffected
