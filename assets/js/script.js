$(document).ready(function() {

    $('.img').click(function() {
        $('.opsi').slideToggle(500)
    })

    $('#upload').click(function() {
        $('#form').slideToggle(500);
    })

    $('#btn').click(function() {
        $('#navbarNav').slideToggle(400);
        $('#navbarNav').addClass('active')
    })

    $('#coba').click(function() {
        $('#admin').slideToggle(500);
        $('#bg').fadeToggle(500)
    })

    $('.cek').mouseenter(function() {
        $(this).find('.detail').slideToggle(500);
    })
    $('.cek').mouseleave(function() {
        $(this).find('.detail').slideToggle(500);
    })

    // $('td, th').hover(function(){
    //     var warna1 =  Math.random()
    //     $(this).css('fontSize', '17px');
    //     $(this).css('color', 'blue');
    //     $(this).css('fontWeight', 'bold');
    // })
    
    // $('th').mouseleave(function(){
    //     $(this).css('color', 'gray');
    //     $(this).css('fontWeight', 'bold');
    // })
    // $('td').mouseleave(function(){
    //     $(this).css('color', 'gray');
    //     $(this).css('fontWeight', 'normal');
    // })
    
    $('#btn_administrasi').click(function() {
        $('#administrasi').slideToggle(500);
        $('#administrasi').focus();
        $('#bg').fadeIn(500);
    })

    $('.btn_tambah_siswa, .btn_tambah_kelas, .btn_tambah_jurusan').click(function(){
        $('.form_tambah_kelas').slideToggle(800)
        $('.form_tambah_siswa').slideToggle(800)
        $('.form_tambah_jurusan').slideToggle(800)
        $('#bg-blur').fadeToggle(500)
        // alert("OK")
    })
    $('#btn_batal').click(function(){
        $('.form_tambah_siswa').slideToggle(500)
        $('.form_tambah_kelas').slideToggle(500)
        $('.form_tambah_jurusan').slideToggle(500)
        $('#bg-blur').fadeToggle(500)
        // alert("OK")
    })

    $('#cuk').click(function(){
        $('#petugas').slideToggle(500);
        $('#bg').fadeToggle(500)      
    })
    
    $('.tutup').mouseenter(function(){
        $(this).css('backgroundColor', 'red')
        $(this).css('color', 'white')
    })
    $('.tutup').mouseleave(function(){
        $(this).css('backgroundColor', 'white')
        $(this).css('color', 'gray')
    })
    $('.tutup_administrasi').click(function(){
        $('#administrasi').slideToggle(500)
        $('#bg').fadeToggle(500)
    })
    $('.tutup_admin').click(function(){
        $('#admin').slideToggle(500)
        $('#bg').fadeToggle(500)
    })
    $('.tutup_petugas').click(function(){
        $('#petugas').slideToggle(500)
        $('#bg').fadeToggle(500)
    })
    
    $('#show').click(function(){
        if($('#show').is(':checked')){
            $('#password').attr('type', 'text');
            $('#textShow').text('Sembunyikan Password')
        }else{
            $('#password').attr('type', 'password');
            $('#textShow').text('Tampilkan Password')
        }
        
    })

    
})