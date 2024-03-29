<img class="nail" src="<?= $thumbnail ?>" alt="">

<img class="sur" src="<?= $file ?>" alt="">

<script>
  window.onload = function() {
    let nail = document.querySelector('.nail');
    let sur = document.querySelector('.sur');
    console.log(sur.naturalWidth, sur.naturalHeight);
    console.log(nail.naturalWidth, nail.naturalHeight);
    console.log(nail)
  }
</script>