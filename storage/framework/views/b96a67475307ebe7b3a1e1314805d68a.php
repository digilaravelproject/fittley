<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Choose Your Plan - Fittelly</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .plan-card { transition: all 0.3s ease; }
        .plan-card:hover { transform: translateY(-4px); }
        .popular-badge { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Choose Your Fitness Plan</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Get unlimited access to live sessions, expert content, and premium features
            </p>
        </div>

        <!-- Plans Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="plan-card bg-white rounded-xl shadow-lg overflow-hidden relative <?php echo e($plan->is_popular ? 'ring-2 ring-purple-500' : ''); ?>">
                <?php if($plan->is_popular): ?>
                <div class="popular-badge text-white text-center py-2 text-sm font-semibold">
                    Most Popular
                </div>
                <?php endif; ?>
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-2"><?php echo e($plan->name); ?></h3>
                    <p class="text-gray-600 text-sm mb-4"><?php echo e($plan->description); ?></p>
                    
                    <div class="mb-6">
                        <div class="flex items-baseline">
                            <span class="text-3xl font-bold text-gray-900">Rs.<?php echo e(number_format($plan->price, 0)); ?></span>
                            <span class="text-gray-500 ml-1">/<?php echo e($plan->billing_cycle); ?></span>
                        </div>
                        <?php if($plan->trial_days > 0): ?>
                        <p class="text-sm text-green-600 font-medium mt-1"><?php echo e($plan->trial_days); ?>-day free trial</p>
                        <?php endif; ?>
                    </div>

                    <!-- Features -->
                    <ul class="space-y-2 mb-6">
                        <?php if($plan->features['access_fitlive'] ?? false): ?>
                        <li class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Live Fitness Sessions
                        </li>
                        <?php endif; ?>
                        
                        <li class="flex items-center text-sm">
                            <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <?php echo e($plan->features['max_devices'] ?? 1); ?> Device(s)
                        </li>

                        <ul class="space-y-2">
                            <?php $__currentLoopData = $plan->features ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="flex items-center text-sm">
                                    <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" 
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" 
                                            clip-rule="evenodd">
                                        </path>
                                    </svg>
                                    <?php echo e($feature); ?>

                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>

                    </ul>

                    <button onclick="selectPlan('<?php echo e($plan->id); ?>', '<?php echo e($plan->name); ?>', <?php echo e($plan->price); ?>)" 
                            class="w-full py-3 px-4 rounded-lg font-semibold <?php echo e($plan->is_popular ? 'bg-purple-600 hover:bg-purple-700 text-white' : 'bg-gray-900 hover:bg-gray-800 text-white'); ?> transition-colors">
                        Choose Plan
                    </button>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Referral Code Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Have a referral code? Save money! 💰</h3>
            <div class="flex gap-4">
                <input type="text" id="referralCode" placeholder="Enter referral code" 
                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                <button onclick="applyReferralCode()" 
                        class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition-colors">
                    Apply Code
                </button>
            </div>
            <div id="referralMessage" class="mt-2 text-sm"></div>
        </div>
    </div>

    <!-- Payment Modal -->
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Complete Your Subscription</h3>
            
            <div id="selectedPlanDetails" class="bg-gray-50 rounded-lg p-4 mb-4"></div>
            
            <form id="payment-form">
                <div id="card-element" class="p-3 border border-gray-300 rounded-lg mb-4">
                    <!-- Stripe Elements will create form elements here -->
                </div>
                <div id="card-errors" role="alert" class="text-red-600 text-sm mb-4"></div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="closePaymentModal()" 
                            class="flex-1 py-2 px-4 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" id="submit-button" 
                            class="flex-1 py-2 px-4 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold">
                        Subscribe Now
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Payment functionality would go here
        function selectPlan(planId, planName, price) {
            document.getElementById('selectedPlanDetails').innerHTML = `
                <h4 class="font-semibold">${planName}</h4>
                <p class="text-lg font-bold">Price: $${price}</p>
            `;
            document.getElementById('paymentModal').classList.remove('hidden');
            document.getElementById('paymentModal').classList.add('flex');
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
            document.getElementById('paymentModal').classList.remove('flex');
        }
    </script>
</body>
</html>
<?php /**PATH /home/u945294333/domains/purple-gaur-534336.hostingersite.com/public_html/resources/views/subscription/plans.blade.php ENDPATH**/ ?>