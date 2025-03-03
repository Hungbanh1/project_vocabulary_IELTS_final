var config = document.getElementById("config");
var route_search = document.getElementsByClassName("route_search");

var defaultUrl = config.dataset.defaultUrl;
var route_add = config.dataset.routeAdd;
var route_add_parapharse = config.dataset.routeAddParapharse;
var is_parapharse = config.dataset.isParapharse;
var route_search = route_search[0].dataset.routeSearch;

$('.btn-add-vocabulary').click(function(e) {
    e.preventDefault(); // Ngăn form submit
    $('.content').addClass("loading");
    $(".form-control").removeClass("is-invalid"); // Xóa class lỗi
    $(".invalid-feedback").text(""); // Xóa thông báo lỗi cũ
    // const year = $("#select_year").val();
    const english = $("#english").val();
    const vietnam = $("#vietnam").val();
    const type_vocabulary  = $("#type_vocabulary").val();
    console.log(defaultUrl);
    console.log("dayladas...");
    
    if(is_parapharse == "parapharse" || type_vocabulary == 6){
        var new_is_parapharse = 1
    }else{
        var new_is_parapharse = 0
    }
    data = {
        english: english,
        vietnam: vietnam,
        type_vocabulary : type_vocabulary ,
        is_parapharse: Number(new_is_parapharse),
    }
    console.log("Dữ liệu gửi:", data); // Kiểm tra dữ liệu trước khi gửi
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route_add,
        type: "POST",
        data: data,
        success: function(response) {
            $('.content').append(response);
            setTimeout(function() {
                $(".content").removeClass("loading");
                Swal.fire({
                    title: "Thành công!",
                    text: "Thêm từ vựng thành công!",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() =>{
                    setTimeout(() => {
                        window.location.href = response.redirect_url;
                    }, 200);
                });
            }, 500);
        },
        error: function(xhr) {
            // $(".content").removeClass("loading");
            setTimeout(function() {
                $(".content").removeClass("loading");
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    console.log(errors);
                    
                    // Duyệt qua từng lỗi và hiển thị dưới input
                    Object.keys(errors).forEach(function(key) {
                        // console.log(key);
                        
                        $("#" + key).addClass(
                            "is-invalid"); // Thêm class đỏ vào input
                        $("#" + key + "-error").text(errors[key][
                            0
                        ]); // Hiển thị lỗi
                    });
                } else {
                    Swal.fire("Lỗi!", "Có lỗi xảy ra. Vui lòng thử lại!", "error");
                }
            }, 500);
        },
        complete: function() {
        },

    })

})
$('.btn-add-parapharse').click(function(e) {
    e.preventDefault(); // Ngăn form submit
    $('.content').addClass("loading");
    $(".form-control").removeClass("is-invalid"); // Xóa class lỗi
    $(".invalid-feedback").text(""); // Xóa thông báo lỗi cũ
    // const year = $("#select_year").val();
    const english = $("#english").val();
    const vietnam = $("#vietnam").val();
    console.log(route_add_parapharse);
    
    data = {
        english: english,
        vietnam: vietnam,
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: route_add_parapharse,
        type: "POST",
        data: data,
        success: function(response) {
            $('.content').html(response);
            setTimeout(function() {
                $(".content").removeClass("loading");
                Swal.fire({
                    title: "Thành công!",
                    text: "Thêm từ vựng thành công!",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() =>{
                    setTimeout(() => {
                        window.location.href = response.redirect_url;
                    }, 200);
                });
            }, 500);
        },
        error: function(xhr) {
            // $(".content").removeClass("loading");
            setTimeout(function() {
                $(".content").removeClass("loading");
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    console.log(errors);
                    
                    // Duyệt qua từng lỗi và hiển thị dưới input
                    Object.keys(errors).forEach(function(key) {
                        console.log(key);
                        
                        $("#" + key).addClass(
                            "is-invalid"); // Thêm class đỏ vào input
                        $("#" + key + "-error").text(errors[key][
                            0
                        ]); // Hiển thị lỗi
                    });
                } else {
                    Swal.fire("Lỗi!", "Có lỗi xảy ra. Vui lòng thử lại!", "error");
                }
            }, 500);
        },
        complete: function() {
        },

    })

})


$('.btn-search').click(function(e) {
    e.preventDefault(); // Ngăn form submit
    $('.content').addClass("loading");
    $(".form-control").removeClass("is-invalid"); // Xóa class lỗi
    $(".invalid-feedback").text(""); // Xóa thông báo lỗi cũ
    const keyword = $("#keyword").val();
    const url = route_search + "?keyword=" + encodeURIComponent(keyword);
    console.log(url);

    data = {
        keyword: keyword,
    }
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        type: "GET",
        data: data,
        success: function(response) {
            
            $('.content').append(response);
            setTimeout(function() {
                if(response.status == false){
                        $(".content").removeClass("loading");
                        Swal.fire("Lỗi!", response.message, "error")
                }
                else{
                    $(".content").removeClass("loading");
                }
            }, 500);
        
        },
        error: function(xhr) {
            $(".content").removeClass("loading");
            Swal.fire("Lỗi!", "khong tim thay", "error");
          
        },
       

    })

})

//delete vocabulary
$(document).on('click', '.btn-delete-vocabulary, .btn-delete-parapharse', function() {
    let vocabularyId = $(this).data('id');
    var url_voca =  defaultUrl + "/delete/" + vocabularyId ;
    var url_para =  defaultUrl + "/parapharse/delete/" + vocabularyId ;
    var url  = is_parapharse == "parapharse"
        ? url_para
        : url_voca;
        console.log(url_voca);
        console.log(url_para);
        
    console.log(vocabularyId);
    console.log(defaultUrl);
    
    Swal.fire({
        title: "Xác nhận xóa?",
        text: "Bạn có chắc chắn muốn xóa từ vựng này không?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Xóa",
        cancelButtonText: "Hủy"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "GET",
                url: url,
                data: {
                    id: vocabularyId
                },
                success: function(response) {
                    Swal.fire({
                        title: "Đã xóa!",
                        text: response.message,
                        icon: "success",
                        timer: 1000, 
                        showConfirmButton: false
                    }).then(() => {
                        setTimeout(() => {
                            window.location.href = response.redirect_url;
                        }, 200);
                    });
                },
                error: function(xhr) {
                    console.log(xhr);
                    
                    Swal.fire("Lỗi!", "Không thể xóa từ vựng.", xhr.vocabulary);
                }
            });
        }
    });
});

//search vocabulary
$(document).ready(function() {
    var timeout = null;
    var url = defaultUrl + "/search/searchajax/";
    var assetUrl = defaultUrl;

    var getColor = function(type_id) {
        var colors = {
            '1': '#fd7e14', // adv - màu cam
            '2': '#dc3545', // adj - màu đỏ
            '3': '#007bff', // v - màu xanh dương
            '4': '#28a745', // n - màu xanh lá
            '5': '#6c757d' // cụm từ - màu xám
        };
        return colors[type_id] || '#6c757d';
    };

    var getTypeName = function(type_id) {
        var types = {
            '1': 'Adv',
            '2': 'Adj',
            '3': 'V',
            '4': 'N',
            '5': 'Phrase',
            '6': 'Parapharse'
        };
        return types[type_id] || 'Phrase';
    };
    
    var createVocabularyItem = function(index, value) {
        var color = getColor(value.type_id);
        var typeName = getTypeName(value.type_id);
        
        var content = `
             <div class="col-xl-6 col-sm-6 vocabulary-item">
        <ul class="list-unstyled">
           <li class="d-flex align-items-center mb-2">
<p class="mr-2">${index + 1}/</p>
<p class="vocabulary-vn mr-2" style="color: ${color};">${value.english}</p>
<p style="color: ${color};">(${typeName})</p>
<p class="mx-3">:</p>
<p class="vocabulary-en" style="color: #6c757d;">${value.vietnam}</p>

</li>
<li>
<div class="d-flex list_action">
    <button style="border:none" data-toggle="modal" data-target="#myModalEdit"
        data-eng="${value.english}" data-vn="${value.vietnam}"
        data-type="${value.type_id}" data-id="${value.id}">
        <img src="${assetUrl}/public/img/edit.png" alt="edit vocabulary"
            class="action-icon">
    </button>
    <button class="delete-link btn-delete-vocabulary" data-id="${value.id}">
        <img src="${assetUrl}/public/img/delete.png" alt="" class="action-icon">
    </button>
    <button style="border:none; margin-left:5px" data-toggle="modal"
        data-target="#ModalParapharse" data-eng="${value.english}"
        data-vn="${value.vietnam}" data-type="${value.type_id}"
        data-id="${value.id}">
        <i class="fa-solid fa-plus" style="color:#44ca44"></i>
    </button>
</div>
</li>
        </ul>
    </div>
`;
        return content;
    };
    $('.keyword').keyup(function() {
        clearTimeout(timeout);
        timeout = setTimeout(function() {
            var data = {
                keyword: $('.keyword').val(),
            };
            // console.log(data);

            $.ajax({
                type: 'get',
                dataType: 'json',
                data: data,
                url: url,
                success: function(data) {
                    $('#main_content').empty();
                    // console.log(data.vocabulary);

                    if (data.vocabulary.length > 0) {
                        var content = data.vocabulary.map(function(value,
                            index) {
                            return createVocabularyItem(index, value);
                        }).join('');
                        $('#main_content').html(content);
                    } else {
                        $('#main_content').html(`
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
                        Không có từ vựng
                    </div>
                </div>
            `);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.error('Lỗi AJAX:', xhr.status, thrownError);
                },
            });
        }, 200);
    });
});